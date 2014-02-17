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

use fpdf\FPDF_EXTENDED;

/**
 * Write a grid of labels to a pdf
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Labels extends FPDF_EXTENDED
{
    private $settings = array(
        'unit' => 'mm',
        'border' => false,
        'lineHeight' => null,
        'font' => array(
            'family' => 'Arial',
            'size' => 10
        ),
        'cell' => array(
            'size' => array(
                'width' => 60,
                'height' => 20
            ),
            'spacing' => array(
                'vertical' => 5,
                'horizontal' => 5
            )
        ),
        'page' => array(
            'size' => array(
                'width' => 210,
                'height' => 297
            ),
            'margin' => array(
                'top' => 10,
                'right' => 10,
                'bottom' => 10,
                'left' => 10
            )
        )
    );

    private $cells = array();

    public function __construct(array $settings = null)
    {
        $this->settings = array_replace_recursive($this->settings, (array)$settings);

        parent::__construct(
            0,
            $this->getOrientation(),
            $this->settings['unit'],
            array_values($this->settings['page']['size'])
        );

        $this->SetCreator('pdflabels');
        $this->SetTitle('labels');
        $this->SetFont($this->settings['font']['family'], '', $this->settings['font']['size']);
        $this->Setmargins(
            $this->settings['page']['margin']['left'],
            $this->settings['page']['margin']['top'],
            $this->settings['page']['margin']['right']
        );
        $this->SetAutoPageBreak(false);
    }

    public function getOrientation()
    {
        if ($this->settings['page']['size']['width'] > $this->settings['page']['size']['height']) {
            return 'L';
        }

        return 'P';
    }

    public function addCell($text)
    {
        $this->cells[] = trim($text);
    }

    public function getCell($index)
    {
        if (isset($this->cells[$index])) {
            return $this->cells[$index];
        }

        return "";
    }

    public function getNrOfLinesInLabel()
    {
        $maxNrOfLines = 1;

        foreach ($this->cells as $cell) {
            $lines = count(explode("\n", $cell));
            if ($lines > $maxNrOfLines) {
                $maxNrOfLines = $lines;
            }
        }

        return $maxNrOfLines;
    }

    public function getLineHeight()
    {
        if (isset($this->settings['lineHeight'])) {
            return $this->settings['lineHeight'];
        }

        return $this->settings['cell']['size']['height'] / $this->getNrOfLinesInLabel();
    }

    public function getNrOfCols()
    {
        $printableWidth = $this->settings['page']['size']['width']
            - $this->settings['page']['margin']['left']
            - $this->settings['page']['margin']['right'];

        $cols = 0;

        do {
            $cols++;
            $currentWidth = $this->settings['cell']['size']['width'] * ($cols + 1)
                + $this->settings['cell']['spacing']['vertical'] * $cols;
        } while ($currentWidth <= $printableWidth);

        return $cols;
    }

    public function getNrOfRows()
    {
        return ceil(count($this->cells) / $this->getNrOfCols());
    }

    public function getNrOfRowsPerPage()
    {
        $printableHeight = $this->settings['page']['size']['height'] - $this->settings['page']['margin']['bottom'];
        $rowsPerPage = 0;
        $y = 0;

        while ($y + $this->settings['cell']['size']['height'] <= $printableHeight) {
            $rowsPerPage++;
            $y = $this->settings['page']['margin']['top']
                + $this->settings['cell']['size']['height'] * $rowsPerPage
                + $this->settings['cell']['spacing']['horizontal'] * ($rowsPerPage + 1);
        }

        return $rowsPerPage;
    }

    public function getNrOfCellsPerPage()
    {
        return $this->getNrOfCols() * $this->getNrOfRowsPerPage();
    }

    public function getGrid()
    {
        $rowsPerPage = $this->getNrOfRowsPerPage();
        $nrOfCols = $this->getNrOfCols();
        $pages = array();
        $page = array();

        foreach (range(0, $this->getNrOfRows()-1) as $row) {
            foreach (range(0, $nrOfCols-1) as $col) {
                $rowOnPage = $row - count($pages) * $rowsPerPage;

                if ($rowOnPage >= $rowsPerPage) {
                    $pages[] = $page;
                    $page = array();
                    $rowOnPage = 0;
                }
                
                $page[] = array(
                    'x' => $this->settings['page']['margin']['left']
                        + $this->settings['cell']['size']['width'] * $col
                        + $this->settings['cell']['spacing']['vertical'] * $col,

                    'y' => $this->settings['page']['margin']['top']
                        + $this->settings['cell']['size']['height'] * $rowOnPage
                        + $this->settings['cell']['spacing']['horizontal'] * ($rowOnPage + 1),

                    'content' => $this->getCell($nrOfCols * $row + $col)
                );
            }
        }

        $pages[] = $page;
        return $pages;
    }

    protected function draw()
    {
        $lineHeight = $this->getLineHeight();

        foreach ($this->getGrid() as $page) {
            $this->AddPage();
            foreach ($page as $cell) {
                $this->SetXY($cell['x'], $cell['y']);
                $this->MultiCell(
                    $this->settings['cell']['size']['width'],
                    $lineHeight,
                    $cell['content'],
                    $this->settings['border']
                );
            }
        }
    }
}
