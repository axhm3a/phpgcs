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

namespace Axhm3a\Phpgcs;

use Axhm3a\Phpgcs\Model\File;
use Axhm3a\Phpgcs\View\ConsoleView;
use Axhm3a\Phpgcs\View\ErrorView;
use Axhm3a\Phpgcs\View\View;

class Controller
{
    /**
     * @param string $path
     * @param int $showPhpInternalConstants
     * @param array $ignoredConstants
     * @return View
     */
    public function run($path, $showPhpInternalConstants, array $ignoredConstants, array $ignoredPaths)
    {
        try {
            if (empty($path)) {
                throw new Exception('no path specified');
            }

            $files = [];
            $Directory = new \RecursiveDirectoryIterator($path);
            $Iterator = new \RecursiveIteratorIterator($Directory);
            $Regex = new \RegexIterator($Iterator, '/^.+(\.php|\.phtml)$/i', \RecursiveRegexIterator::GET_MATCH);

            foreach ($Regex as $something) {
                $files[] = $something[0];
            }

            $constantGuesser = new ConstantGuesser();
            $filesWithConstants = [];

            if($showPhpInternalConstants === true) {
                $ignoredConstants = array_merge($ignoredConstants,array_keys(get_defined_constants()));
            }

            foreach ($files as $file) {
                foreach ($ignoredPaths as $ignoredPath) {
                    if (strstr($file, $ignoredPath)) {
                        continue 2;
                    }
                }

                $code = file_get_contents($file);
                $constants = $constantGuesser->scan($code, $ignoredConstants);

                if (!empty($constants)) {
                    $fileWithConstants = new File();
                    $fileWithConstants->setPath($file);
                    $fileWithConstants->setConstants($constants);
                    $filesWithConstants[] = $fileWithConstants;
                }
            }

            $view = new ConsoleView();
            $view->setFiles($filesWithConstants);


        } catch (Exception $e) {
            $view = new ErrorView();
            $view->setExcpetion($e);
        }

        return $view;
    }
}