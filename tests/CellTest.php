<?php

namespace pdflabels;

class CellTest extends \PHPUnit_Framework_TestCase
{
    private function getCell()
    {
        return new Cell(
            array(
                'size' => array(
                    'width' => 10,
                    'height' => 10,
                ),
                'padding' => array(
                    'top' => 5,
                    'left' => 5,
                    'right' => 5,
                    'bottom' => 5,
                ),
                'margin' => array(
                    'top' => 5,
                    'left' => 5,
                    'right' => 5,
                    'bottom' => 5,
                )
            )
        );
    }

    public function testGetContentEdge()
    {
        $this->assertEquals(
            new Edge(10, 10, 10, 10),
            $this->getCell()->getContentEdge()
        );
    }

    public function testGetPaddingEdge()
    {
        $this->assertEquals(
            new Edge(5, 5, 20, 20),
            $this->getCell()->getPaddingEdge()
        );
    }

    public function testGetMarginEdge()
    {
        $this->assertEquals(
            new Edge(0, 0, 30, 30),
            $this->getCell()->getMarginEdge()
        );
    }
}
