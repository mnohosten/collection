<?php

namespace Pilulka\Collection\DataSource;

use Pilulka\Collection\DataSource;
use Pilulka\Collection\Filter;
use Pilulka\Collection\Node;

class ArraySource extends \ArrayIterator implements DataSource
{

    private $filters;

    public function valid()
    {
        if(!parent::valid()) return false;
        return true;
    }


    public function applyFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    public function add(Node $node)
    {
        $this->append($node);
    }

    public function delete($id)
    {
        $this->offsetUnset($id);
    }

    public function exists($id)
    {
        return $this->offsetExists($id);
    }

}
