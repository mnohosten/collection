<?php

namespace Tests\Pilulka\Collection\DataSource;

use Pilulka\Collection\DataSource\ArraySource;
use Pilulka\Collection\Filter;
use Pilulka\Collection\Node;

class ArraySourceTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $source = $this->source();
        $count = $source->count();
        $source->add(new Node('24', ['a' => 99, 'b' => 444]));
        $this->assertEquals($count + 1, $source->count());
    }

    public function testDelete()
    {
        $source = $this->source();
        $count = $source->count();
        $source->delete(0);
        $this->assertEquals($count - 1, $source->count());
    }

    public function testExists()
    {
        $this->assertTrue($this->source()->exists(0));
    }

    public function testIteration()
    {
        foreach ($this->source() as $node) {
            $this->assertInstanceOf(Node::class, $node);
        }
        $this->assertEquals(count($this->rawSource()), $this->source()->count());
    }


    public function testIterateOverFilteredSource()
    {
        $source = $this->source()->applyFilter(new Filter('a', '=', 3));
        foreach ($source as $node) {
            $this->assertEquals(3, $node->get('a'));
        }
    }

    public function testFitering()
    {
        $this->assertEquals(2, $this->source()->applyFilter(new Filter('b', '>', 20))->count());
        $this->assertEquals(
            1,
            $this->source()
                ->applyFilter(new Filter('a', '>', -1))
                ->applyFilter(new Filter('b', '=', 2))
                ->count()
        );
    }

    public function testSlice()
    {
        $source = $this->source();
        $this->assertEquals(5, $source->slice(5, 1)->count());
        $this->assertEquals(3, $source->slice(3, 2)->count());
    }

    public function testSort()
    {
        $source = $this->source();
        $a = [];
        $b = [];
        $raw = $this->source()->getArrayCopy();
        foreach ($raw as $key=>$data) {
            $a[$key] = $data['a'];
            $b[$key] = $data['b'];
        }
        array_multisort(
            $a, SORT_ASC,
            $b, SORT_DESC,
            $raw
        );
        $this->assertEquals(
            $raw,
            $source->order(['a' => SORT_ASC, 'b' => SORT_DESC])->getArrayCopy()
        );
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
            ['a' => 5, 'b' => 5],
            ['a' => 233, 'b' => -5],
            ['a' => 345, 'b' => 778],
            ['a' => 55, 'b' => 59],
        ];
    }
}

