<?php
namespace Pilulka\Collection;

use Pilulka\Collection\Exception\InvalidArgumentException;

class Filter
{

    const EQUAL = '=';
    const NOT_EQUAL = '!=';
    const GREATER = '>';
    const LESS = '<';
    const GREATER_OR_EQUAL = '>=';
    const LESS_OR_EQUAL = '<=';
    const CONTAINS = '><';
    const REGEXP = 'regexp';
    const IN = 'in';

    private $attribute;
    private $rule;
    private $value;

    /**
     * Filter constructor.
     * @param $attribute
     * @param $rule
     * @param $value
     */
    public function __construct($attribute, $rule, $value)
    {
        $this->setAttribute($attribute);
        $this->setRule($rule);
        $this->setValue($value);
    }

    private function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    private function setRule($rule)
    {
        $this->validateRule($rule);
        $this->rule = $rule;
    }

    private function setValue($value)
    {
        $this->value = $value;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getRule()
    {
        return $this->rule;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAvailableRules()
    {
        static $rules = null;
        if(!isset($rules)) {
            $rules = (new \ReflectionClass($this))->getConstants();
        }
        return $rules;
    }

    private function validateRule($rule)
    {
        if(!in_array($rule, $this->getAvailableRules())) {
            throw new InvalidArgumentException(
                "Unknown rule: `{$rule}`"
            );
        }
    }

}
