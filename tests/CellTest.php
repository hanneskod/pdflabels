<?php
/**
 * This file is part of pdflabels.
 *
 * Copyright (c) 2014 Hannes Forsgård
 *
 * pdflabels is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * pdflabels is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pdflabels.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ledgr\pdflabels;

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
