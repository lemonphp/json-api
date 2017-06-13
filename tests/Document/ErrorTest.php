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

use Lemon\JsonApi\Document\Error;
use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Tests\TestCase;

class ErrorTest extends TestCase
{
    public function testEmptyErrorIsEmptyObject()
    {
        $this->assertEquals('{}', json_encode(new Error()));
    }

    public function testErrorWithFullSetOfProperties()
    {
        $e = new Error();
        $e->setId('test_id');
        $e->setAboutLink('http://localhost');
        $e->setStatus('404');
        $e->setCode('OMG');
        $e->setTitle('Error');
        $e->setDetail('Nothing is found');
        $e->setSourcePointer('/data');
        $e->setSourceParameter('test_param');
        $e->setMeta(new Meta(['foo' => 'bar']));

        $this->assertEqualsAsJson(
            [
                'id' => 'test_id',
                'links' => [
                    'about' => 'http://localhost',
                ],
                'status' => '404',
                'code' => 'OMG',
                'title' => 'Error',
                'detail' => 'Nothing is found',
                'source' => [
                    'pointer' => '/data',
                    'parameter' => 'test_param',
                ],
                'meta' => [
                    'foo' => 'bar',
                ],
            ],
            $e
        );
    }
}
