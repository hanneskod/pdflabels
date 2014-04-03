<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\pdflabels;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Cell
{
    private static $defaults = array(
        'size' => array(
            'width' => 70,
            'height' => 30
        ),
        'padding' => array(
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'left' => 0
        ),
        'margin' => array(
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'left' => 0
        )
    );

    private $contentEdge, $paddingEdge, $marginEdge;

    public $size, $padding, $margin;

    public function __construct(array $values)
    {
        $values = array_replace_recursive(self::$defaults, $values);
        $this->size = $values['size'];
        $this->padding = $values['padding'];
        $this->margin = $values['margin'];
        $this->contentEdge = new Edge(
            $values['margin']['left'] + $values['padding']['left'],
            $values['margin']['top'] + $values['padding']['top'],
            $values['size']['width'],
            $values['size']['height']
        );
        $this->paddingEdge = new Edge(
            $values['margin']['left'],
            $values['margin']['top'],
            $values['size']['width'] + $values['padding']['left'] + $values['padding']['right'],
            $values['size']['height'] + $values['padding']['top'] + $values['padding']['bottom']
        );
        $this->marginEdge = new Edge(
            0,
            0,
            $values['size']['width'] + $values['margin']['left'] + $values['margin']['right'] + $values['padding']['left'] + $values['padding']['right'],
            $values['size']['height'] + $values['margin']['top'] + $values['margin']['bottom'] + $values['padding']['top'] + $values['padding']['bottom']
        );
    }

    public function getContentEdge()
    {
        return $this->contentEdge;
    }

    public function getPaddingEdge()
    {
        return $this->paddingEdge;
    }

    public function getMarginEdge()
    {
        return $this->marginEdge;
    }
}
