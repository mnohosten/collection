<?php

namespace Pilulka\Collection;

interface DataSource extends \Iterator, \Countable
{

    const SORT_ASC = SORT_ASC;
    const SORT_DESC = SORT_DESC;

    public function applyFilter(Filter $filter);
    public function add(Node $node);
    public function delete($id);
    public function exists($id);
    public function slice($count, $offset=0);
    public function order(array $orderRules);

}
