<?php

/*
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2015 Daniel Basten <axhm3a@gmail.com>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

class ConsoleViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Axhm3a\Phpgcs\View\ConsoleView
     */
    private $view;

    protected function setUp()
    {
        $this->view = new \Axhm3a\Phpgcs\View\ConsoleView();
    }

    protected function tearDown()
    {
        $this->view = null;
    }

    public function testEmptyResult()
    {
        $this->view->setFiles(array());

        $expected = <<<EXPECTED

0 Usage(s) in 0 File(s).


EXPECTED;

        $this->assertEquals($expected, (string) $this->view);
    }

    public function testOneFileTwoConstants()
    {
        $constantOne = $this->getMock('\Axhm3a\Phpgcs\Model\Constant');

        $constantOne->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('foo'));
        $constantOne->expects($this->once())
            ->method('getLine')
            ->will($this->returnValue(1));

        $constantTwo = $this->getMock('\Axhm3a\Phpgcs\Model\Constant');

        $constantTwo->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('bar'));

        $constantTwo->expects($this->once())
            ->method('getLine')
            ->will($this->returnValue(2));

        $file = $this->getMock('\Axhm3a\Phpgcs\Model\File');
        $file->expects($this->once())
            ->method('getConstants')
            ->will($this->returnValue(
                array($constantOne, $constantTwo)
            ));

        $this->view->setFiles(array($file));

        $expected = <<<EXPECTED

\t1:\tfoo
\t2:\tbar

2 Usage(s) in 1 File(s).


EXPECTED;

        $this->assertEquals($expected, (string) $this->view);
    }
}