<?php

namespace Tests\Pilulka\Collection;

use Pilulka\Collection\Exception\InvalidArgumentException;
use Pilulka\Collection\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase
{

    public function testCorrectInstance()
    {
        $this->assertInstanceOf(Filter::class, new Filter('name', '=', 12));
    }

    public function testExceptionOnInvalidFilterRule()
    {
        $this->expectException(InvalidArgumentException::class);
        new Filter('name', '%nonsense%', 12);
    }

    public function testGetters()
    {
        $attribute = 'name';
        $rule = Filter::EQUAL;
        $value = 12;
        $filter = new Filter($attribute, $rule, $value);
        $this->assertEquals($attribute, $filter->getAttribute());
        $this->assertEquals($rule, $filter->getRule());
        $this->assertEquals($value, $filter->getValue());
    }

}

