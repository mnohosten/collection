<?php

namespace Pilulka\Collection;

interface DataSource extends \Iterator, \Countable
{

    public function applyFilter(Filter $filter);
    public function add(Node $node);
    public function delete($id);
    public function exists($id);

}
