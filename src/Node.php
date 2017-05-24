<?php

namespace Pilulka\Collection;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Node
{

    private $data;

    public function __construct($data)
    {
    }

    public function id()
    {
        return $this->get('id');
    }

    public function get($attribute)
    {
        static $accessor = null;
        if(!isset($accessor)) {
            $accessor = PropertyAccess::createPropertyAccessor();
        }
        return $accessor->getValue($this->data, "[{$attribute}]");
    }

}
