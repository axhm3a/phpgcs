[![Build Status](https://travis-ci.org/axhm3a/phpgcs.png?branch=master)](https://travis-ci.org/axhm3a/phpgcs)

phpgcs
======
A command line tool that shows usages of global constants in php code.

In 2013 I worked on an legacy eCommerce application relying heavily on global constants for runtime configuration. I made this tool to find and substitute all constant usages in order to sustain testability.

Usage
-----
A listing of available options:
```
Usage: phpgcs [switches] [PATH]

--ignore-builtin
        ignores pre defined constants like PHP_EOL, LOCK_EX...

--ignore-const
        list of constants to be ignored
        --ignore-const=CONST1,CONST2,...
--exclude-path
        list of path patterns to be excluded
        --exclude-paths=.phtml,tests/,...
```

A sample
--------
it lists all files in path passed by argument with usage of global constants by name and line number
```
./phpgcs tests/
tests/Axhm3a/Phpgcs/Fixture.php
        10:     BOOL_RUNNING_LOCAL
        12:     METHOD
        17:     PHP_EOF

3 Usage(s) in 1 File(s).
```

Content of Fixture.php:
```
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: axhm3a
 * Date: 25.09.13
 * Time: 19:52
 * To change this template use File | Settings | File Templates.
 */
use NETRADA\BlaBla as Bla;
BOOL_RUNNING_LOCAL;
METHOD();
METHOD;
ClassName::CONSTANT;
$object->SOME_THING;
$object->SOME_THING();
true;
PHP_EOF;
self::variable;
new self;
Bla instanceof ClassName;
Netrada\Something::getInstance();
class Route implements RouteAdapterInterface, \NETRADA_Cache_Interface_IWrappable{

}
```

