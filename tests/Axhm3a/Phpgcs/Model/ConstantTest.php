<?php

/*
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2013 Daniel Basten <axhm3a@gmail.com>
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

class ConstantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Axhm3a\Phpgcs\Model\Constant
     */
    private $constant;

    protected function setUp()
    {
        $this->constant = new \Axhm3a\Phpgcs\Model\Constant();
    }

    protected function tearDown()
    {
        $this->constant = null;
    }

    public function testGetSetLine()
    {
        $this->constant->setLine(4);

        $this->assertEquals(4, $this->constant->getLine());
    }

    public function testGetSetName()
    {
        $this->constant->setName('foo');

        $this->assertEquals('foo', $this->constant->getName());
    }
}