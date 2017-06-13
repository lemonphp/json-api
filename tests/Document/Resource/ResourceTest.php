<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Tests\Document\Resource;

use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Document\Resource\ResourceObject;
use Lemon\JsonApi\Tests\TestCase;

/**
 * Resource Objects
 *
 * @see http://jsonapi.org/format/#document-resource-objects
 */
class ResourceTest extends TestCase
{
    /**
     * @param array $expected
     * @param mixed $data
     * @dataProvider resourceProvider
     */
    public function testSerialization(array $expected, $data)
    {
        $this->assertEqualsAsJson($expected, $data);
    }

    public function resourceProvider()
    {
        return [
            [
                [
                    'type' => 'books',
                ],
                new ResourceIdentifier('books'),
            ],
            [
                [
                    'type' => 'books',
                    'id' => '42abc',
                ],
                new ResourceIdentifier('books', '42abc'),
            ],
            [
                [
                    'type' => 'books',
                    'id' => '42abc',
                    'meta' => [
                        'foo' => 'bar',
                    ],
                ],
                new ResourceIdentifier('books', '42abc', new Meta(['foo' => 'bar'])),
            ],
            [
                [
                    'type' => 'books',
                    'id' => '42abc',
                    'attributes' => [
                        'attr' => 'val',
                    ],
                    'relationships' => [
                        'author' => [
                            'meta' => [
                                'a' => 'b',
                            ],
                        ],
                    ],
                    'links' => [
                        'self' => 'http://localhost',
                    ],
                    'meta' => [
                        'foo' => 'bar',
                    ],
                ],
                (function () {
                    $resource = new ResourceObject('books', '42abc');
                    $resource->setMeta(new Meta(['foo' => 'bar']));
                    $resource->setAttribute('attr', 'val');
                    $resource->setLink('self', 'http://localhost');
                    $resource->setRelationship('author', Relationship::fromMeta(new Meta(['a' => 'b'])));
                    return $resource;
                })(),
            ],
        ];
    }

    /**
     * @param string $name
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid attribute name
     * @dataProvider             invalidAttributeNames
     */
    public function testAttributeCanNotHaveReservedNames(string $name)
    {
        $r = new ResourceObject('books', 'abc');
        $r->setAttribute($name, 1);
    }

    public function invalidAttributeNames(): array
    {
        return [
            ['id'],
            ['type'],
        ];
    }
}
