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

/**
 * Shorthands to create labels from standard sizes
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class LabelsFactory
{
    public static function createStd()
    {
        return new Labels(
            array(
                'font' => array(
                    'size' => 11
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
                    'margins' => array(
                        'top' => 10,
                        'right' => 10,
                        'bottom' => 10,
                        'left' => 10
                    )
                )
            )
        );
    }
}
