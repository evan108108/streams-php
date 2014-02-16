<?php

require dirname(__FILE__) . "/../src/Streams/Stream.php";

use Streams as S;

class StreamTest extends PHPUnit_Framework_TestCase
{
    private $array = array(1, 2, 3, 4);

    public function testConstructor()
    {
        $stream = new S\Stream($this->array);

        $this->assertTrue($stream instanceof S\Stream);

        $this->assertEquals($this->array, $stream->getElements());
    }

    public function testMap()
    {
        $stream = new S\Stream($this->array);

        $callback = function($item) {
            return $item * 2;
        };

        $stream = $stream->map($callback);
        $this->assertEquals(array(2,4,6,8), $stream->getElements());

        $stream = $stream->map($callback)->map($callback);
        $this->assertEquals(array(8, 16, 24, 32), $stream->getElements());
    }

    public function testFilter()
    {
        $stream = new S\Stream($this->array);

        $predicate = function($item) {
            return !($item % 2);
        };

        $stream = $stream->filter($predicate);
        $this->assertEquals(array(2, 4), $stream->getElements());

        $stream = new S\Stream($this->array);

        $predicateEven = function($item) {
            return !($item % 2);
        };

        $predicateEqualsFour = function($item) {
            return $item == 4;
        };

        $stream = $stream->filter($predicateEven)->filter($predicateEqualsFour);
        $this->assertEquals(array(4), $stream->getElements());
    }

    public function testIteratorableBehavior()
    {
      $stream = new S\Stream($this->array);

      $position = 0;
      foreach($stream as $key=>$value) {
        $this->assertEquals($position, $key);
        $this->assertEquals(++$position, $value);
      }
    }

    public function testCountableBehavior()
    {
      $stream = new S\Stream($this->array);

      $this->assertEquals(4, count($stream));
    }

    public function testArrayAccessBehavior()
    {
      $stream = new S\Stream($this->array);

      for($cnt=0; $cnt<count($stream); $cnt++) {
        $this->assertEquals($cnt+1, $stream[$cnt]);
      }
    }

}
