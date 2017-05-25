<?php

namespace Pilulka\Collection\DataSource;

use Pilulka\Collection\DataSource;
use Pilulka\Collection\Node;

class ArraySource extends \ArrayIterator implements DataSource
{

    use IteratorFiltration;

    public function slice($count, $offset = 0)
    {
        $i = 0;
        $response = new ArraySource([]);
        $iterate = false;
        foreach ($this as $key=>$node) {
            if(!$iterate && $key == $offset) $iterate = true;
            if(!$iterate) continue;
            if($i++ >= $count) break;
            $response->add($node);
        }
        return new self($response);
    }

    public function order(array $orderRules)
    {
        $sortMap = [];
        $innerData = $this->getArrayCopy();
        foreach ($innerData as $key=>$data) {
            foreach ($orderRules as $orderKey=>$orderRule) {
                $sortMap[$orderKey][$key] = $data[$orderKey];
            }
        }
        $params = [];
        foreach ($orderRules as $key=>$rule) {
            $params[] = $sortMap[$key];
            $params[] = $rule;
        }
        $params[] = &$innerData;
        call_user_func_array('array_multisort', $params);
        return new self($innerData);
    }

    public function add(Node $node)
    {
        if(is_null($node->id())) {
            $this->append($node);
        } else {
            $this->offsetSet($node->id(), $node);
        }
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
