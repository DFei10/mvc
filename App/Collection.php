<?php

namespace App;

class Collection implements \Iterator, \ArrayAccess
{
    public function __construct(private array $items = [])
    {
    }

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid()
    {
        return current($this->items) === false ? next($this->items) : current($this->items);
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
