<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package Lemon\JsonApi\Tests
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    public static function assertEqualsAsJson($expected, $actual, string $message = '')
    {
        self::assertEquals(json_encode($expected), json_encode($actual), $message);
    }
}
