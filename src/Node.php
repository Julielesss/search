<?php
class Node
{
    public object $value;
    public string $fieldToSort;
    public ?Node $left = null;
    public ?Node $right = null;

    public function __construct($value, string $fieldToSort)
    {
        $this->value = $value;
        $this->fieldToSort = $fieldToSort;
    }
}