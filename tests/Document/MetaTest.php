<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Tests\Document;

use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Tests\TestCase;

class MetaTest extends TestCase
{
    public function testConvertedToObjects()
    {
        $this->assertEquals('{"foo":"bar"}', json_encode(new Meta(['foo' => 'bar'])));
    }

    public function testPhpArraysAreConvertedToObjects()
    {
        $this->assertEquals('{"0":"foo"}', json_encode(new Meta(['foo'])));
    }
}
