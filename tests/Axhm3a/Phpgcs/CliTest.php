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

class CliTest extends PHPUnit_Framework_TestCase
{
    public function testCliWithoutArguments()
    {
        $cliMock = $this->getMock('\Axhm3a\Phpgcs\Cli');
        $cliMock->expects($this->once())->method("execute")->with(
            "", false, array(), array()
        );
        CliMock::setCliMock($cliMock);

        CliMock::run(array(null));
    }

    public function testCliWithPath()
    {
        $cliMock = $this->getMock('\Axhm3a\Phpgcs\Cli');
        $cliMock->expects($this->once())->method("execute")->with(
            ".", false, array(), array()
        );
        CliMock::setCliMock($cliMock);

        CliMock::run(array(null,"."));
    }

    public function testCliWithAllParameters()
    {
        $cliMock = $this->getMock('\Axhm3a\Phpgcs\Cli');
        $cliMock->expects($this->once())->method("execute")->with(
            ".", true, array("FOO","BAR"), array(".phtml", "tests/")
        );
        CliMock::setCliMock($cliMock);

        CliMock::run(array(null,".", "--ignore-builtin","--ignore-const=FOO,BAR", "--exclude-paths=.phtml,tests/"));
    }
}

class CliMock extends \Axhm3a\Phpgcs\Cli
{
    /**
     * @var CliMock
     */
    private static $cliMock;

    protected static function create()
    {
        return self::$cliMock;
    }

    /**
     * @param CliMock $cliMock
     */
    public static function setCliMock($cliMock)
    {
        self::$cliMock = $cliMock;
    }
}