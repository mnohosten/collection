<?php

namespace Pilulka\Collection;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Node
{

    private $id;
    private $data;
    private static $accessor;

    /**
     * Node constructor.
     * @param $id
     * @param $data
     */
    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }


    public function id()
    {
        return $this->id;
    }

    public function get($attribute)
    {
        $accessor = self::accessor();
        if($accessor->isReadable($this->data, $attribute)) { // try object access
            return $accessor->getValue($this->data, $attribute);
        }
        return $accessor->getValue($this->data, "[{$attribute}]");
    }

    private static function accessor()
    {
        if(!isset(self::$accessor)) {
            self::$accessor = PropertyAccess::createPropertyAccessor();
        }
        return self::$accessor;
    }

}
