<?php

namespace pdflabels;

class Edge
{
    public $x, $y, $width, $height;

    public function __construct($x, $y, $width, $height)
    {
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }
}
