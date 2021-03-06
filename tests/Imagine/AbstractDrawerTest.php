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

use Imagine\Point;
use Imagine\Point\Center;
use Imagine\Box;

abstract class AbstractDrawerTest extends \PHPUnit_Framework_TestCase
{
    public function testDrawASmileyFace()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->chord(new Point(200, 200), new Box(200, 150), 0, 180, new Color('fff'), false)
            ->ellipse(new Point(125, 100), new Box(50, 50), new Color('fff'))
            ->ellipse(new Point(275, 100), new Box(50, 50), new Color('fff'), true);

        $canvas->save('tests/Imagine/Fixtures/smiley.png', array('quality' => 100));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/smiley.png'));

        unlink('tests/Imagine/Fixtures/smiley.png');
    }

    public function testDrawAnEllipse()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->ellipse(new Center($canvas->getSize()), new Box(300, 200), new Color('fff'), true);

        $canvas->save('tests/Imagine/Fixtures/ellipse.png', array('quality' => 100));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/ellipse.png'));

        unlink('tests/Imagine/Fixtures/ellipse.png');
    }

    public function testDrawAPieSlice()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->pieSlice(new Point(200, 150), new Box(100, 200), 45, 135, new Color('fff'), true);

        $canvas->save('tests/Imagine/Fixtures/pie.png');

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/pie.png'));

        unlink('tests/Imagine/Fixtures/pie.png');
    }


    public function testDrawAChord()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->chord(new Point(200, 150), new Box(100, 200), 45, 135, new Color('fff'), true);

        $canvas->save('tests/Imagine/Fixtures/chord.png');

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/chord.png'));

        unlink('tests/Imagine/Fixtures/chord.png');
    }

    public function testDrawALine()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->line(new Point(50, 50), new Point(350, 250), new Color('fff'))
            ->line(new Point(50, 250), new Point(350, 50), new Color('fff'));

        $canvas->save('tests/Imagine/Fixtures/lines.png', array(
            'quality' => 100
        ));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/lines.png'));

        unlink('tests/Imagine/Fixtures/lines.png');
    }

    public function testDrawAPolygon()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->polygon(array(
                new Point(50, 20),
                new Point(350, 20),
                new Point(350, 280),
                new Point(50, 280),
            ), new Color('fff'), true);

        $canvas->save('tests/Imagine/Fixtures/polygon.png', array(
            'quality' => 100
        ));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/polygon.png'));

        unlink('tests/Imagine/Fixtures/polygon.png');
    }

    public function testDrawADot()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));

        $canvas->draw()
            ->dot(new Point(200, 150), new Color('fff'))
            ->dot(new Point(200, 151), new Color('fff'))
            ->dot(new Point(200, 152), new Color('fff'))
            ->dot(new Point(200, 153), new Color('fff'));

        $canvas->save('tests/Imagine/Fixtures/dot.png', array(
            'quality' => 100
        ));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/dot.png'));

        unlink('tests/Imagine/Fixtures/dot.png');
    }

    public function testDrawAnArc()
    {
        $imagine = $this->getImagine();

        $canvas = $imagine->create(new Box(400, 300), new Color('000'));
        $size   = $canvas->getSize();

        $canvas->draw()
            ->arc(new Center($size), $size->scale(0.5), 0, 180, new Color('fff'));

        $canvas->save('tests/Imagine/Fixtures/arc.png', array(
            'quality' => 100
        ));

        $this->assertTrue(file_exists('tests/Imagine/Fixtures/arc.png'));

        unlink('tests/Imagine/Fixtures/arc.png');
    }

    /**
     * @return Imagine\ImagineInterface
     */
    abstract protected function getImagine();
}
