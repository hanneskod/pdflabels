<?php

namespace ledgr\pdflabels;

class LabelsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateStd()
    {
        $labels = LabelsFactory::createStd();
        $this->assertEquals(3, $labels->getNrOfCols());
    }

    public function testCreateHama50450()
    {
        $labels = LabelsFactory::createHama50450();
        $this->assertEquals(24, $labels->getNrOfCellsPerPage());
    }
}
