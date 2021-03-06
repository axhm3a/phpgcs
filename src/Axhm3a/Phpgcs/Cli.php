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

namespace Axhm3a\Phpgcs;

/**
 * Class Cli
 * Entrypoint for Cli-Application
 * @package Axhm3a\Phpgcs
 */
class Cli extends Controller
{
    public static function run(array $argv)
    {
        return static::create()->execute(
            (isset($argv[1]) ? (string)$argv[1] : '') ,
            self::checkParameter($argv, 2, '--ignore-builtin'),
            self::checkParameter($argv, 3, '--ignore-const') ? explode(',', self::getValuesFromParam($argv[3])) : array(),
            self::checkParameter($argv, 4, '--exclude-paths') ? explode(',', self::getValuesFromParam($argv[4])): array()
        );
    }

    /**
     * @return Controller
     */
    protected static function create()
    {
        $controller = new Controller();
        return $controller;
    }


    /**
     * @param string $parameter
     * @return mixed
     */
    protected static function getValuesFromParam($parameter)
    {
        $array = explode('=', $parameter);
        return $array[1];
    }

    /**
     * @param array $argv
     * @return bool
     */
    protected static function checkParameter(array $argv, $index, $parameterName)
    {
        return (isset($argv[$index]) && strpos($argv[$index], $parameterName) === 0);
    }
}