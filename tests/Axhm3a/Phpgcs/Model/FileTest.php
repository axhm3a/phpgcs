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

class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Axhm3a\Phpgcs\Model\File
     */
    private $file;

    protected function setUp()
    {
        $this->file = new \Axhm3a\Phpgcs\Model\File();
    }

    protected function tearDown()
    {
        $this->file = null;
    }

    public function testConstants()
    {
        $this->file->setConstants(array('foo' => 'bar'));

        $this->assertEquals(array('foo' => 'bar'), $this->file->getConstants());
    }

    public function testPath()
    {
        $this->file->setPath('foo');
        $this->assertEquals('foo', $this->file->getPath());
    }
}
