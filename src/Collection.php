<?php

namespace Pilulka\Collection;

class Collection
{

    /** @var DataSource */
    private $dataSource;

    public function withFilter(Filter $filter)
    {
        $this->dataSource->applyFilter($filter);
        return $this;
    }

    public function withFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->withFilter($filter);
        }
        return $this;
    }

    public function all()
    {
        foreach ($this->dataSource as $item) {
            yield $item;
        }
    }

    public function add(Node $node)
    {
        $this->dataSource->add($node);
        return $this;
    }

    public function remove(Node $node)
    {
        $this->dataSource->delete($node->id());
        return $this;
    }

    public function has(Node $node)
    {
        return $this->dataSource->exists($node->id());
    }

    public function count()
    {
        return $this->dataSource->count();
    }

}
