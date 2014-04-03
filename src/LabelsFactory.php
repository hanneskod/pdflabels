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
 * Shorthands to create labels from standard sizes
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
