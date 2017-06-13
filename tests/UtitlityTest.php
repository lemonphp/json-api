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

use Lemon\JsonApi\Utility;

/**
 * Class UtitlityTest
 *
 * @package Lemon\JsonApi\Tests
 */
class UtitlityTest extends TestCase
{
    /**
     * @dataProvider arrayProvider
     */
    public function testArrayFilter($array, $expected)
    {
        $this->assertEquals($expected, Utility::arrayFilter($array));
    }

    /**
     * @return array
     */
    public function arrayProvider()
    {
        return [
            [[], new \stdClass()],
            [['a' => '', 'b' => null, 'c' => 0], (object) ['a' => '', 'c' => 0]],
        ];
    }
}
