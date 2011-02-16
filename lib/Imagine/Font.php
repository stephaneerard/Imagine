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
    private $path;
    private $size;
    private $color;

    public function __construct($path, $size, Color $color)
    {
        $this->path  				= $path;
        $this->size  				= $size;
        $this->color 				= $color;
    }

    /**
     * Returns the path of the font.
     * If $this->isInternal(), returns the number
     * defining the internal font
     * 
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getColor()
    {
        return $this->color;
    }
    
    public function isInternal()
    {
    	return is_numeric($this->path);
    }
}
