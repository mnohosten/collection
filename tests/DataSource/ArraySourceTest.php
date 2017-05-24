<?php

namespace Tests\Pilulka\Collection\DataSource;

use Pilulka\Collection\DataSource\ArraySource;

class ArraySourceTest extends \PHPUnit_Framework_TestCase
{

    public function testApplyFilter()
    {
    }

    public function testAdd()
    {
    }

    public function testDelete()
    {
    }

    public function testExists()
    {
    }

    public function testIteration()
    {
        foreach ($this->source() as $item) {
            $this->assertTrue(is_array($item), 'Given test item is not array.');
        }
        $this->assertEquals(count($this->rawSource()), $this->source()->count());
    }


    public function testFiltered()
    {
    }

    private function source()
    {
        return new ArraySource($this->rawSource());
    }

    /**
     * @return array
     */
    private function rawSource()
    {
        return [
            ['a' => 1, 'b' => 2],
            ['a' => 3, 'b' => 4],
            ['a' => 3, 'b' => 5],
        ];
    }
}

