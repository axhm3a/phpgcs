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

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    private $root;

    /**
     * @var Axhm3a\Phpgcs\Controller
     */
    private $controller;

    protected function setUp()
    {
        $this->root = \org\bovigo\vfs\vfsStream::setup();
        $this->controller = new \Axhm3a\Phpgcs\Controller();
    }

    protected function tearDown()
    {
        $this->controller = null;
    }

    public function testNoPathExcpetionOutput()
    {
        $expected = <<<EXPECTED
[31m[no path specified][0m


EXPECTED;

        $this->assertStringEndsWith($expected,(string)$this->controller->execute('', true, array(), array()));
    }

    public function testSingleFileInPath() {

        $this->controller = $this->getMockBuilder(
            '\Axhm3a\Phpgcs\Controller'
        )->setMethods(array("createConsoleView"))->getMock();

        $controllerTestViewMock = new ControllerTestViewMock();
        $this->controller->expects($this->once())
            ->method("createConsoleView")
            ->will(
                $this->returnValue(
                    $controllerTestViewMock
                )
            );

        \org\bovigo\vfs\vfsStream::newFile('example.php')
            ->withContent('<?php "dd";')
            ->at($this->root);

        $this->controller->execute($this->root->url(), false, array(), array());

        $this->assertEmpty($controllerTestViewMock->getFiles());
    }

    public function testMultipleFilesInPath() {

        $this->controller = $this->getMockBuilder(
            '\Axhm3a\Phpgcs\Controller'
        )->setMethods(array("createConsoleView"))->getMock();

        $controllerTestViewMock = new ControllerTestViewMock();
        $this->controller->expects($this->once())
            ->method("createConsoleView")
            ->will(
                $this->returnValue(
                    $controllerTestViewMock
                )
            );

        \org\bovigo\vfs\vfsStream::newFile('example.php')
            ->withContent('<?php echo "dd";')
            ->at($this->root);

        \org\bovigo\vfs\vfsStream::newFile('example2.php')
            ->withContent('<?php echo "dd";')
            ->at($this->root);

        \org\bovigo\vfs\vfsStream::newFile('example3.php')
            ->withContent('<?php echo PHP_EOL;')
            ->at($this->root);

        $this->controller->execute($this->root->url(), false, array(), array());

        $files = $controllerTestViewMock->getFiles();

        $this->assertEquals("vfs://root/example3.php", $files[0]->getPath());
    }
}

class ControllerTestViewMock extends \Axhm3a\Phpgcs\View\ConsoleView
{
    /**
     * @return \Axhm3a\Phpgcs\Model\File[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}