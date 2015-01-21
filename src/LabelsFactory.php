<?php

namespace pdflabels;

/**
 * Shorthands to create labels from standard sizes
 */
class LabelsFactory
{
    public static function createStd()
    {
        return new Labels();
    }

    public static function createHama50450()
    {
        return new Labels(
            array(
                'lineHeight' => 5,
                'font' => array(
                    'size' => 9
                ),
                'cell' => array(
                    'size' => array(
                        'width' => 50,
                        'height' => 22
                    ),
                    'margin' => array(
                        'top' => 15,
                        'right' => 10,
                        'left' => 10,
                        'bottom' => 0
                    )
                )
            )
        );
    }
}
