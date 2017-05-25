<?php

namespace Pilulka\Collection\DataSource;

use Pilulka\Collection\Filter;
use Pilulka\Collection\Node;

trait IteratorFiltration
{

    private $filters = [];

    public function current()
    {
        $current = parent::current();
        return new Node($this->key(), $current);
    }

    public function count()
    {
        $i=0;
        foreach ($this as $item) $i++;
        return $i;
    }

    public function valid()
    {
        if (!parent::valid()) return false;
        if(!$this->validateNode($this->current())) {
            $this->next();
            return $this->valid();
        }
        return true;
    }

    public function applyFilter(Filter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    private function validateNode(Node $node)
    {
        foreach ($this->filters as $filter) {
            if (!$this->isValid($node, $filter)) return false;
        }
        return true;
    }

    private function isValid(Node $node, Filter $filter)
    {
        $callbackMap = [
            Filter::EQUAL => 'validateEqual',
            Filter::NOT_EQUAL => 'validateNotEqual',
            Filter::GREATER => 'validateGreater',
            Filter::LESS => 'validateLess',
            Filter::GREATER_OR_EQUAL => 'validateGreaterOrEqual',
            Filter::LESS_OR_EQUAL => 'validateLessOrEqual',
            Filter::CONTAINS => 'validateContains',
            Filter::REGEXP => 'validateRegexp',
            Filter::IN => 'validateIn',
        ];
        $method = $callbackMap[$filter->getRule()];
        return $this->$method($node, $filter);
    }

    private function validateEqual(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) == $filter->getValue();
    }

    private function validateNotEqual(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) != $filter->getValue();
    }

    private function validateGreater(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) > $filter->getValue();
    }

    private function validateLess(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) < $filter->getValue();
    }

    private function validateGreaterOrEqual(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) >= $filter->getValue();
    }

    private function validateLessOrEqual(Node $node, Filter $filter)
    {
        return $this->value($node, $filter) <= $filter->getValue();
    }

    private function validateContains(Node $node, Filter $filter)
    {
        return strpos($this->value($node, $filter), $filter->getValue()) !== false;
    }

    private function validateRegexp(Node $node, Filter $filter)
    {
        return (bool)preg_match($filter->getValue(), $this->value($node, $filter));
    }

    private function validateIn(Node $node, Filter $filter)
    {
        return in_array($this->value($node, $filter), $filter->getValue());
    }

    private function value(Node $node, Filter $filter)
    {
        return $node->get($filter->getAttribute());
    }

}
