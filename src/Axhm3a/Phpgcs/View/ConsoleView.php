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

namespace Axhm3a\Phpgcs\View;

use Axhm3a\Phpgcs\Model\File;

class ConsoleView implements  View
{
    /**
     * @var File[]
     */
    protected $files;

    /**
     * @param \Axhm3a\Phpgcs\Model\File[] $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = '';

        $countFiles = 0;
        $countUsages = 0;

        foreach ($this->files as $file) {
            $countFiles += 1;
            $output .= $file->getPath() . "\n";

            foreach ($file->getConstants() as $constant) {
                $countUsages += 1;
                $output .= "\t" . $constant->getLine() . ":\t" . $constant->getName() . "\n";
            }
        }

        $output .= "\n$countUsages Usage(s) in $countFiles File(s).\n\n";

        return $output;
    }


}