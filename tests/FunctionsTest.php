<?php

namespace tests;

require_once (__DIR__ . '\..\api\inc\functions.php');

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class FunctionsTest extends TestCase
{
    public function testCheckAppKey() {
        $appkey = 1234;
        $_SERVER["HTTP_APPKEY"] = $appkey;
        self::assertTrue(checkAppKey());
        $appkey = '1234';
        $_SERVER["HTTP_APPKEY"] = $appkey;
        assertTrue(checkAppKey());
    }
}