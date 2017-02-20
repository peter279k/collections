<?php

namespace Vulcan\Collections;

use ArrayAccess;
use Countable;
use Vulcan\Collections\Support\Arr;
use Vulcan\Collections\Contracts\Collection as CollectionInterface;

class Collection implements CollectionInterface, ArrayAccess, Countable
{
    /**
     * Items of the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection instance.
     *
     * @param  mixed  $items
     */
    public function __construct($items)
    {
        $this->items = Arr::transmute($items);
    }

    /**
     * Helper static method to easily create a new Collection instance.
     *
     * @param  mixed  $items;
     * @return self
     */
    public static function make($items)
    {
        return new static($items);
    }

    /**
     * Retrieve all the items from the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get the specified item from the collection.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function get($key)
    {
        return Arr::get($this->items, $key);
    }

    /**
     * Push an item to the collection.
     *
     * @param  mixed  $value
     */
    public function push($value)
    {
        return $this->itemSet($value);
    }

    /**
     * Put the specified item in the collection with the given key.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     */
    public function put($key, $value)
    {
        return $this->itemSet($value, $key);
    }

    /**
     * Remove the given item from the collection.
     *
     * @param  mixed  $key
     */
    public function remove($key)
    {
        return $this->itemUnset($key);
    }

    /**
     * Determine if the given item exists in the collection.
     *
     * @param  mixed  $key
     */
    public function exists($key)
    {
        return $this->itemExists($key);
    }

    /**
     * Return the number of items in the collection.
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Return the first item from the collection.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->itemFirst();
    }

    /**
     * Return the last item from the collection.
     *
     * @return mixed
     */
    public function last()
    {
        return $this->itemLast();
    }

    /**
     * Loop through the items with the defined callback.
     *
     * @param  callable  $callable
     * @return void
     */
    public function each(callable $callable)
    {
        foreach ($this->items as $key => $item) {
            $callable($item, $key);
        }

        return $this;
    }

    /**
     * Apply the callable to the collection items.
     *
     * @param  callable  $callable
     * @return self
     */
    public function map(callable $callable)
    {
        $keys    = array_keys($this->items);
        $results = array_map($callable, $this->items, $keys);

        return new self($results);
    }

    /**
     * Filter the collection items through the callable.
     *
     * @param  callable  $callable
     * @return self
     */
    public function filter(callable $callable)
    {
        $results = [];

        foreach ($this->items as $key => $item) {
            if ($callable($item, $key)) {
                $results[] = $item;
            }
        }

        return new self($results);
    }

    /**
     * Reject the collection items through the callable.
     *
     * @param  callable  $callable
     * @return self
     */
    public function reject(callable $callable)
    {
        return $this->filter(function($item, $key) use ($callable) {
            return ! $callable($item, $key);
        });
    }

    //

    /**
     * Whether or not an offset exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Returns the value at specified offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unsets an offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    //

    /**
     * Set the given array value with the provided key or index.
     *
     * @param  mixed  $value
     * @param  mixed  $key
     */
    private function itemSet($value, $key = null)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the given key or index from the array.
     *
     * @param  mixed  $key
     * @return void
     */
    private function itemUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Checks if the given key or index exists in the array.
     *
     * @param  mixed  $key
     * @return bool
     */
    private function itemExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Set the internal pointer of an array to its first element
     * and return its value.
     *
     * @return mixed
     */
    private function itemFirst()
    {
        $items = $this->items;

        return reset($items);
    }

    /**
     * Set the internal pointer of an array to its last element
     * and return its value.
     *
     * @return mixed
     */
    private function itemLast()
    {
        $items = $this->items;

        return end($items);
    }
}
