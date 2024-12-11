<?php

namespace Honed\Nav;

use Honed\Core\Primitive;

class Nav
{
    /** 
     * @var array<string, array<\Honed\Nav\NavItem>>
     */
    protected $items = [];

    /**
     * @var string|true
     */
    protected $group = 'default';

    public function __construct($group, $items)
    {
        $this->setItems($items);
    }

    private function setItems()
    {

    }

    /**
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $item
     */
    public function item($group, ...$item)
    {
        $this->items[] = $item;
    }    


    /**
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $group
     */
    public function items($group, ...$items)
    {
        $this->item($group, ...$items);
    }

    /**
     * Set the current group to use
     * 
     * @param string $group
     */
    public function use(string $group)
    {
        $this->group = $group;
    }

    /**
     * @param string $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $items
     */
    public function group(string|true $group, ...$items)
    {

    }


    public function get(string|true $group = 'default')
    {
        // items could be empty

    }

    /**
     * Alias for `get`
     */
    public function for(string $group = 'default')
    {
        
    }
    



}
