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
class Stream implements \Iterator
{
    /**
     * elements the elements over which the stream will operate
     *
     * @var array
     */
    private $elements;

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

		/**
		 * 
		 */ 
		public function rewind()
    {
        reset($this->elements);
    }
  
    public function current()
    {
        return current($this->elements);
    }
  
    public function key() 
    {
        return key($this->elements);
    }
  
    public function next() 
    {
        return next($this->elements);
    }
  
    public function valid()
    {
        return (key($this->elements) !== NULL && key($this->elements) !== FALSE);
    }

    /**
     * map function
     *
     * @param callable $callback
     * @return void
     */
    public function map( callable $callback )
		{
			return new self(
				array_map($callback, $this->elements)
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
				array_map($callback, $this->elements)
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
				array_values(array_filter($this->elements, $callback))
			);
    }

    /**
     * getElements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
		}

}
