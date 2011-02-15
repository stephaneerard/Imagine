<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine;

final class Font
{
    private $font;
    private $size;

    public function __construct($font, $size)
    {
        $this->font = $font;
        $this->size = $size;
    }

    public function getFont()
    {
        return $this->font;
    }

    public function getSize()
    {
        return $this->size;
    }
}
