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

class ConstantGuesserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Axhm3a\Phpgcs\ConstantGuesser
     */
    private $constantGuesser;

    protected function setUp()
    {
        $this->constantGuesser = new \Axhm3a\Phpgcs\ConstantGuesser();
    }

    protected function tearDown()
    {
        $this->constantGuesser = null;
    }


    public function testEmptyFile()
    {
        $this->assertEmpty(
            $this->constantGuesser->scan("")
        );
    }

    public function testStaticFile()
    {
        $result = $this->constantGuesser->scan("HTML_MAILS");
        $this->assertEmpty($result);
    }

    public function testScript()
    {
        $result = $this->constantGuesser->scan("<?php HTML_MAILS");

        $this->assertEquals(1,$result[0]->getLine());
        $this->assertEquals('HTML_MAILS',$result[0]->getName());
    }

    public function testFixture()
    {
        $code = file_get_contents(realpath(dirname(__FILE__) . '/Fixture.php'));
        $result = $this->constantGuesser->scan($code);
        $this->assertEquals(3,count($result));
    }

    public function testFixtureWithoutPhpInternals()
    {
        $code = file_get_contents(realpath(dirname(__FILE__) . '/Fixture.php'));
        $result = $this->constantGuesser->scan($code,array('PHP_EOF'));
       // var_dump($result);
        $this->assertEquals(2,count($result));
    }
}
