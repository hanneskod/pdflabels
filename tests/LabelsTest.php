<?php

namespace pdflabels;

class LabelsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOrientation()
    {
        $landscape = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 100,
                        'width' => 200
                    )
                )
            )
        );
        $this->assertEquals('L', $landscape->getOrientation());

        $portrait = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 200,
                        'width' => 100
                    )
                )
            )
        );
        $this->assertEquals('P', $portrait->getOrientation());
    }

    public function testGetCell()
    {
        $labels = new Labels;
        $labels->addCell('foobar');
        $this->assertEquals('foobar', $labels->getCell(0));
        $this->assertEquals('', $labels->getCell(1));
    }

    public function testGetNrOfLinesInLabel()
    {
        $labels = new Labels;
        $this->assertEquals(1, $labels->getNrOfLinesInLabel());
        $labels->addCell("Line1\nLine2\nLine3");
        $this->assertEquals(3, $labels->getNrOfLinesInLabel());
    }

    public function testGetLineHeight()
    {
        $labels = new Labels(array('cell' => array('size' => array('height' => 100))));
        $this->assertEquals(100, $labels->getLineHeight());
        $labels->addCell("Line1\nLine2");
        $this->assertEquals(50, $labels->getLineHeight());
    }

    public function testGetLineHeightFromPreset()
    {
        $labels = new Labels(array('lineHeight' => 1000));
        $this->assertEquals(1000, $labels->getLineHeight());
    }

    public function testGetNrOfCols()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('width' => 200)),
                'cell' => array('size' => array('width' => 50))
            )
        );
        $this->assertEquals(4, $labels->getNrOfCols());
    }

    public function testGetNrOfRows()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('width' => 100)),
                'cell' => array('size' => array('width' => 50))
            )
        );
        $this->assertEquals(0, $labels->getNrOfRows());
        $labels->addCell('');
        $labels->addCell('');
        $labels->addCell('');
        $this->assertEquals(2, $labels->getNrOfRows());
    }

    public function testGetNrOfRowsPerPage()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('height' => 200)),
                'cell' => array('size' => array('height' => 50))
            )
        );
        $this->assertEquals(4, $labels->getNrOfRowsPerPage());
    }

    public function testGetNrOfCellsPerPage()
    {
        $labels = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 200,
                        'width' => 200
                    )
                ),
                'cell' => array(
                    'size' => array(
                        'height' => 50,
                        'width' => 50
                    )
                )
            )
        );
        $this->assertEquals(16, $labels->getNrOfCellsPerPage());
    }

    public function testMakePdf()
    {
        $labels = new Labels(
            array(
                'border' => true,
                'page' => array(
                    'size' => array(
                        'height' => 20,
                        'width' => 11
                    ),
                    'margin' => array(
                        'left' => 1
                    )
                ),
                'cell' => array(
                    'size' => array(
                        'height' => 10,
                        'width' => 10
                    )
                )
            )
        );

        $labels->addCell('foo');
        $labels->addCell('bar');
        $labels->addCell('foobar');

        $expected = array(
            array(
                array(
                    'x' => 1,
                    'y' => 0,
                    'content' => 'foo'
                ),
                array(
                    'x' => 1,
                    'y' => 10,
                    'content' => 'bar'
                )
            ),
            array(
                array(
                    'x' => 1,
                    'y' => 0,
                    'content' => 'foobar'
                ),
                array(
                    'x' => 1,
                    'y' => 10,
                    'content' => ''
                )
            )
        );

        // Assert that grid is correct
        $this->assertEquals($expected, $labels->getGrid());

        // Assert that there are no exceptions while making pdf
        $this->assertTrue(!!$labels->getPdf());
    }
}
