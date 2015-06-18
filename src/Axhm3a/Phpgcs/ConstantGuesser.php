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

use Axhm3a\Phpgcs\Model\Constant;

class ConstantGuesser
{
    /**
     * @var array
     */
    protected $keywords = array(
        'true',
        'false',
        'null',
        'TRUE',
        'FALSE',
        'NULL'
    );

    /**
     * @param $code
     * @param array $ignoredConstants
     * @return Constant[]
     */
    public function scan($code, $ignoredConstants = array())
    {
        $constants = array();

        $tokenStream = token_get_all($code);

        foreach($tokenStream as $key => $token) {

            if ($token[0] !== T_STRING) {
                continue;
            }

            if (isset($token[1])
                && (in_array( $token[1], $this->keywords))
            ) {
                continue;
            }

            if (isset($token[1])
                && (in_array( $token[1], $ignoredConstants))
            ) {
                continue;
            }

            // ::
            // ->
            // \
            if (isset($tokenStream[$key -1 ])
                && in_array($tokenStream[$key -1 ][0],array(T_PAAMAYIM_NEKUDOTAYIM, T_OBJECT_OPERATOR, T_NS_SEPARATOR) )
            ) {
                continue;
            }

            // USE
            // CONST
            if (isset($tokenStream[$key -2 ])
                && in_array($tokenStream[$key -2 ][0],array(T_NAMESPACE, T_USE,T_CONST, T_NEW, T_AS, T_INSTANCEOF, T_EXTENDS, T_IMPLEMENTS) )
            ) {
               continue;
            }

            // (
            // ::
            if (isset($tokenStream[$key +1 ])
                && (in_array($tokenStream[$key +1 ][0],array(T_WHITESPACE,T_PAAMAYIM_NEKUDOTAYIM,T_NAMESPACE,T_NS_SEPARATOR) )
                || $tokenStream[$key +1] === "(")
            ) {
                continue;
            }

            $constant = new Constant();
            $constant->setLine($token[2]);
            $constant->setName($token[1]);
            $constants[] = $constant;
        }

        return $constants;
    }
}