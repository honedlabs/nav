<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Exceptions\DuplicateGroupException;
use Honed\Nav\Exceptions\MissingGroupException;
use Illuminate\Support\Arr;

use function array_diff;
use function array_filter;
use function array_intersect;
use function array_keys;
use function array_map;
use function array_merge;
use function array_reduce;
use function array_slice;
use function array_values;
use function count;

class NavManager
{
    /**
     * The navigation items.
     *
     * @var array<string, array<int,NavBase>>
     */
    protected $items = [];

    /**
     * Whether to share all navigation items.
     *
     * @var bool
     */
    protected $all = true;

    /**
     * The only keys to include for sharing.
     *
     * @var array<int,string>
     */
    protected $only = [];

    /**
     * The keys to exclude for sharing.
     *
     * @var array<int,string>
     */
    protected $except = [];

    /**
     * Set a navigation group under a given name.
     *
     * @param  string  $name
     * @param  array<int,NavBase>  $items
     * @return $this
     *
     * @throws DuplicateGroupException
     */
    public function for($name, $items)
    {
        if ($this->has($name) && $this->debugs()) {
            DuplicateGroupException::throw($name);
        }

        /** @var array<int,NavBase> $items */
        Arr::set($this->items, $name, $items);

        return $this;
    }

    /**
     * Add navigation items to an existing group.
     *
     * @param  string  $name
     * @param  array<int,NavBase>  $items
     * @return $this
     *
     * @throws MissingGroupException
     */
    public function add($name, $items)
    {
        if (! $this->has($name)) {
            MissingGroupException::throw($name);
        }

        /** @var array<int,NavBase> $current */
        $current = Arr::get($this->items, $name);

        Arr::set($this->items, $name, array_merge($current, $items));

        return $this;
    }

    /**
     * Determine if one or more navigation group(s) exist.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return bool
     */
    public function has(...$groups)
    {
        /** @var array<int,string> $groups */
        $groups = Arr::flatten($groups);

        if (empty($groups)) {
            return filled($this->items);
        }

        return empty(array_diff($groups, array_keys($this->items)));
    }

    /**
     * Determine if the given navigation group(s) exists.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return bool
     */
    public function exists(...$groups)
    {
        return $this->has(...$groups);
    }

    /**
     * Determine if the given navigation group(s) does not exist.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return bool
     */
    public function missing(...$groups)
    {
        return ! $this->has(...$groups);
    }

    /**
     * Get all the navigation items.
     *
     * @return array<string,array<int,NavBase>>
     */
    public function all()
    {
        return $this->get();
    }

    /**
     * Retrieve navigation groups and their allowed items.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return array<string,array<int,NavBase>>
     *
     * @throws MissingGroupException
     */
    public function get(...$groups)
    {
        /** @var array<int,string> $groups */
        $groups = Arr::flatten($groups);

        if (! $this->has($groups) && $this->debugs()) {
            MissingGroupException::throw($groups);
        }

        $keys = empty($groups) ? array_keys($this->items) : $groups;

        return array_reduce(
            $keys,
            fn (array $acc, string $key) => $acc + [$key => $this->group($key)],
            []
        );
    }

    /**
     * Retrieve the navigation group for the given name.
     *
     * @param  string  $group
     * @return array<int,NavBase>
     */
    public function group($group)
    {
        /** @var array<int,NavBase> */
        $items = Arr::get($this->items, $group);

        return array_values(
            array_filter($items,
                static fn (NavBase $item) => $item->isAllowed()
            )
        );
    }

    /**
     * Set only a given subset to be shared.
     *
     * @param  string|iterable<int,string>  ...$only
     * @return $this
     */
    public function only(...$only)
    {
        $this->all = false;

        $only = Arr::flatten($only);

        $this->only = array_merge($this->only, $only);

        return $this;
    }

    /**
     * Set the given subset to be excluded from being shared.
     *
     * @param  string|iterable<int,string>  ...$except
     * @return $this
     */
    public function except(...$except)
    {
        $this->all = true;

        $except = Arr::flatten($except);

        $this->except = array_merge($this->except, $except);

        return $this;
    }

    /**
     * Get the keys which are to be shared.
     *
     * @return array<int,string>
     */
    public function keys()
    {
        return array_values(
            $this->all
                ? array_diff(array_keys($this->items), $this->except)
                : array_intersect(array_keys($this->items), $this->only)
        );
    }

    /**
     * Get the navigation items to be shared.
     *
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function data()
    {
        $groups = $this->keys();

        return $this->toArray(...$groups);
    }

    /**
     * Search the navigation items for the given term.
     *
     * @param  string  $term
     * @param  int  $limit
     * @param  bool  $caseSensitive
     * @param  string  $delimiter
     * @return array<int,array<string,mixed>>
     */
    public function search($term, $limit = 10, $caseSensitive = true, $delimiter = '/')
    {
        $groups = array_keys($this->items);

        /** @var array<int,array<string,mixed>> $results */
        $results = [];

        foreach ($groups as $group) {
            $items = $this->group($group);

            $this->process($items, null, $term, $caseSensitive, $delimiter, $results, $limit);

            if (count($results) >= $limit) {
                break;
            }
        }

        return array_slice($results, 0, $limit);
    }

    /**
     * Get the navigation items as an array.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function toArray(...$groups)
    {
        $groups = $this->get(...$groups);

        return array_map(
            static fn ($group) => array_map(
                static fn (NavBase $item) => $item->toArray(),
                $group
            ),
            $groups
        );
    }

    /**
     * Recursively process navigation items to search for matches.
     *
     * @param  array<int, NavBase>  $items
     * @param  string|null  $currentPath
     * @param  string  $term
     * @param  bool  $caseSensitive
     * @param  string  $delimiter
     * @param  array<int,array<string,mixed>>  $results
     * @param  int  $limit
     * @return void
     */
    protected function process(
        $items,
        $currentPath,
        $term,
        $caseSensitive,
        $delimiter,
        &$results,
        $limit
    ) {
        foreach ($items as $item) {
            if (count($results) >= $limit) {
                return;
            }

            /** @var string */
            $label = $item->getLabel();

            $isMatch = $caseSensitive
                ? mb_strpos($label, $term) !== false
                : mb_stripos($label, $term) !== false;

            $path = ! $currentPath ? $label : $currentPath.' '.$delimiter.' '.$label;

            if ($isMatch) {
                $results[] = array_merge($item->toArray(), [
                    'path' => $path,
                ]);
            }

            if ($item instanceof NavGroup) {
                $this->process(
                    $item->getItems(),
                    $path,
                    $term,
                    $caseSensitive,
                    $delimiter,
                    $results,
                    $limit
                );
            }
        }
    }

    /**
     * Determine if debug mode is enabled.
     *
     * @return bool
     */
    protected function debugs()
    {
        return (bool) config('nav.debug', false);
    }
}
