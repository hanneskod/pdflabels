<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
        'cell' => array(),
        'page' => array(
            'size' => array(
                'width' => 210,
                'height' => 297
            )
        )
    );

    private $pageBox, $cellBox, $cells;

    public function __construct(array $settings = null)
    {
        $this->settings = array_replace_recursive($this->settings, (array)$settings);

        $this->pageBox = new Cell($this->settings['page']);
        $this->cellBox = new Cell($this->settings['cell']);
        $this->cells = array();

        parent::__construct(
            0,
            $this->getOrientation(),
            $this->settings['unit'],
            array(
                $this->pageBox->getMarginEdge()->width,
                $this->pageBox->getMarginEdge()->height
            )
        );

        $this->SetCreator('pdflabels');
        $this->SetTitle('labels');
        $this->SetFont(
            $this->settings['font']['family'],
            '',
            $this->settings['font']['size']
        );
        $this->Setmargins(
            $this->pageBox->margin['left'],
            $this->pageBox->margin['top'],
            $this->pageBox->margin['right']
        );
        $this->SetAutoPageBreak(false);
    }

    public function getOrientation()
    {
        if ($this->pageBox->getMarginEdge()->width > $this->pageBox->getMarginEdge()->height) {
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

        return $this->cellBox->getContentEdge()->height / $this->getNrOfLinesInLabel();
    }

    public function getNrOfCols()
    {
        return count($this->calcDrawEdges('width'));
    }

    public function getNrOfRows()
    {
        return ceil(count($this->cells) / $this->getNrOfCols());
    }

    public function getNrOfRowsPerPage()
    {
        return count($this->calcDrawEdges('height'));
    }

    public function getNrOfCellsPerPage()
    {
        return $this->getNrOfCols() * $this->getNrOfRowsPerPage();
    }

    public function getGrid()
    {
        $rows = $this->calcDrawEdges('height');
        $cols = $this->calcDrawEdges('width');
        $pages = array();
        $page = array();

        for ($cellCount = 0; $cellCount < count($this->cells); ) {
            foreach ($rows as $posY) {
                foreach ($cols as $posX) {
                    // Make x and y relative to page content box
                    $page[] = array(
                        'x' => $posX + $this->pageBox->getContentEdge()->x,
                        'y' => $posY + $this->pageBox->getContentEdge()->y,
                        'content' => $this->getCell($cellCount)
                    );

                    $cellCount++;
                }
            }

            // New page
            $pages[] = $page;
            $page = array();
        }

        return $pages;
    }

    protected function draw()
    {
        $lineHeight = $this->getLineHeight();

        foreach ($this->getGrid() as $page) {
            $this->AddPage();
            foreach ($page as $cell) {
                $this->SetXY(
                    $cell['x'] + $this->cellBox->getContentEdge()->x,
                    $cell['y'] + $this->cellBox->getContentEdge()->y
                );

                $this->MultiCell(
                    $this->cellBox->getContentEdge()->width,
                    $lineHeight,
                    $cell['content']
                );
                
                if ($this->settings['border']) {
                    $this->rect(
                        $cell['x'] + $this->cellBox->getPaddingEdge()->x,
                        $cell['y'] + $this->cellBox->getPaddingEdge()->y,
                        $this->cellBox->getPaddingEdge()->width,
                        $this->cellBox->getPaddingEdge()->height
                    );
                }
            }
        }
    }

    /**
     * @param  string $dimension 'width' or 'height'
     * @return array  Starting edge values for the chosen dimension
     */
    private function calcDrawEdges($dimension)
    {
        $data = array();

        for ($iteration = 0; ; $iteration++) {
            $edge = $this->cellBox->getMarginEdge()->$dimension * ($iteration + 1);
            if ($edge > $this->pageBox->getContentEdge()->$dimension) {
                break;
            }            
            $data[] = $this->cellBox->getMarginEdge()->$dimension * $iteration;
        }

        return $data;
    }
}
