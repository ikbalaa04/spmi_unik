<?php

/*
|--------------------------------------------------------------------------
| Legacy Framework Compatibility
|--------------------------------------------------------------------------
|
| Laravel 7 and some of its dependencies predate PHP 8.1 tentative return
| types. Suppress only compatibility deprecations before Composer autoloads
| those classes. Warnings, errors, and exceptions remain enabled.
|
*/

if (PHP_VERSION_ID >= 80100) {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
}
