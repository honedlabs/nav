<?php

declare(strict_types=1);

namespace Honed\Nav\Contracts;

interface ManagesNavigation
{
    /**
     * Set a navigation group under a given name.
     *
     * @param  string  $name
     * @param  array<int, \Honed\Nav\NavBase>  $items
     * @return $this
     */
    public function for($name, $items);

    /**
     * Determine if one or more navigation group(s) exist.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return bool
     */
    public function has(...$groups);

    /**
     * Get all the navigation items.
     *
     * @return array<string,array<int,\Honed\Nav\NavBase>>
     */
    public function all();

    /**
     * Retrieve navigation groups and their allowed items.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return array<string,array<int,\Honed\Nav\NavBase>>
     */
    public function get(...$groups);

    /**
     * Retrieve the navigation group for the given name.
     *
     * @param  string  $group
     * @return array<int,\Honed\Nav\NavBase>
     */
    public function group($group);

    /**
     * Set only a given subset to be shared.
     *
     * @param  string|iterable<int,string>  ...$only
     * @return $this
     */
    public function only(...$only);

    /**
     * Set the given subset to be excluded from being shared.
     *
     * @param  string|iterable<int,string>  ...$except
     * @return $this
     */
    public function except(...$except);

    /**
     * Get the navigation items to be shared.
     *
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function data();

    /**
     * Search the navigation items for the given term.
     *
     * @param  string  $term
     * @param  int  $limit
     * @param  bool  $caseSensitive
     * @param  string  $delimiter
     * @return array<int,array<string,mixed>>
     */
    public function search($term, $limit = 10, $caseSensitive = true, $delimiter = '/');

    /**
     * Determine if the descriptions should not be serialized.
     *
     * @return bool
     */
    public function descriptionsDisabled();
}
