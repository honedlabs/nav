<?php

namespace Honed\Nav;

use Honed\Core\Primitive;

class Nav
{
    /** 
     * The navigation items, ordered
     * @var array<string, array<\Honed\Nav\NavItem>>
     */
    protected $items = [];

    /**
     * The groups to select from the items array when retrieving nav items
     * 
     * @var string|true|array<int,string>
     */
    protected $group = 'default';

    public function __construct($group, ...$items)
    {
        $this->setItems($group, ...$items);
    }

    /**
     * @param array<int,string>|string|array<int,array<int,string>>|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $item
     * @return $this
     */
    public function item($group, ...$item): static
    {
        $this->setItems($group, ...$item);
        return $this;
    }    


    /**
     *
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items
     * 
     * @return $this
     */
    public function items($group, ...$items): static
    {
        $this->setItems($group, ...$items);
        return $this;
    }

    /**
     * Set the group to use for retrieving navigations items.
     * 
     * @param string|array<int,string>|true ...$group
     * 
     * @return $this
     */
    public function use(...$group): static
    {
        $this->group = count($group) === 1 ? $group[0] : $group;
        return $this;
    }

    /**
     * Add a set of items to a given group, with the group name being enforced.
     * 
     * @param string $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $items
     */
    public function group(string $group, ...$items): static
    {
        $this->setItems($group, ...$items);
        return $this;
    }

    /**
     * Retrieve the items associated with the provided group(s)
     * 
     * @param string|true|array<int,string> $group
     * @return ($group is string ? array<int,\Honed\Nav\NavItem> : array<string,array<int,\Honed\Nav\NavItem>>)|null
     */
    public function get(string|true|array $group = 'default')
    {
        // items could be empty

    }

    /**
     * Alias for `get`
     */
    public function for(string $group = 'default')
    {
        
    }

    /**
     * Sort the items in a group.
     * 
     * @param string|true|array<int,string> $group
     * @param bool $asc
     * 
     * @return void
     */
    public function sort(string|true|array $group, bool $asc = true): void
    {

    }

        /**
     * Set the items array.
     * 
     */
    private function setItems($group, ...$items): void
    {
        //
    }

    /**
     * Set the retrieval group.
     * 
     * @param string|array<int,string>|true $group
     */
    private function setGroup(string|array|true $group): void
    {
        //
    }

    private function fromUrl(string $url)
    {
        //
    }
}
