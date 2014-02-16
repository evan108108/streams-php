<?php

namespace Streams;

/**
 * Stream
 *
 * @package Streams
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com>
 * @license MIT
 */


class ArrayBehavior implements \Iterator, \ArrayAccess, \Countable
{
  /**
     * elements the elements over which the stream will operate
     *
     * @var array
     */
    private $elements;

    /**
     * getElements
     *
     * @return array
     */
    public function getElements()
    {
      return $this->elements;
    }

    /**
     * __construct
     *
     * Constructor of the class.
     *
     * @param array $elements
     * @return void
     */
    public function __construct( array $elements )
    {
        $this->elements = $elements;
    }

    public function count()
    {
      return count($this->elements);
    }

    /**
     * rewind Iterator function
     *
     * @return viod
     */
    public function rewind()
    {
        reset($this->elements);
    }

    /**
     * current Iterator function
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * key Iterator function
     *
     * @return mixed
     */
    public function key() 
    {
        return key($this->elements);
    }

    /**
     * next Iterator function
     *
     * @return mixed
     */
    public function next() 
    {
        return next($this->elements);
    }

    /**
     * valid Iterator function
     *
     * @return Boolean
     */
    public function valid()
    {
        return (key($this->elements) !== NULL && key($this->elements) !== FALSE);
    }

    /**
     * offsetSet ArrayAccess function
     *
     * @param mixed $offest
     * @param mixed $value
     * @return mixed
     */ 
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->elements[] = $value;
        } else {
            $this->elements[$offset] = $value;
        }
    }

    /**
     * offsetSetExists ArrayAccess function
     *
     * @param mixed $offset
     * @return Boolean
     */ 
    public function offsetExists($offset) {
        return isset($this->elements[$offset]);
    }

    /**
     * offsetUnset ArrayAccess function
     *
     * @param mixed $offset
     * @return viod
     */ 
    public function offsetUnset($offset) {
        unset($this->elements[$offset]);
    }

    /**
     * offsetGet ArrayAccess function
     *
     * @param mixed $offset
     * @return mixed
     */ 
    public function offsetGet($offset) {
        return isset($this->elements[$offset]) ? $this->elements[$offset] : null;
    }
}


class Stream extends ArrayBehavior
{
    /**
     * map function
     *
     * @param callable $callback
     * @return void
     */
    public function map( callable $callback )
    {
      return new self(
        array_map($callback, $this->getElements())
      );
    }

    /**
     * forEachElement
     *
     * This method is intended for containing the side effects, in case you need
     * them. (I am not able to call it foreach because is a reserved keyword)
     *
     * @param callable $callback
     * @return void
     */
    public function forEachElement( callable $callback )
    {
      return new self(
        array_map($callback, $this->getElements())
      );
    }

    /**
     * filter
     *
     * @param callable $callback
     * @return void
     */
    public function filter( callable $callback )
    {
      return new self(
        array_values(array_filter($this->getElements(), $callback))
      );
    }

}

