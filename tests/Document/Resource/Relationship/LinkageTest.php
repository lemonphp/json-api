<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Tests\Document\Resource\Relationship;

use Lemon\JsonApi\Document\Resource\NullResource;
use Lemon\JsonApi\Document\Resource\Relationship\Linkage;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Tests\TestCase;

/**
 * Resource Linkage
 *
 * Resource linkage in a compound document allows a client to link together
 * all of the included resource objects without having to GET any URLs via links.
 *
 * Resource linkage MUST be represented as one of the following:
 * - null for empty to-one relationships.
 * - an empty array ([]) for empty to-many relationships.
 * - a single resource identifier object for non-empty to-one relationships.
 * - an array of resource identifier objects for non-empty to-many relationships.
 *
 * @see http://jsonapi.org/format/#document-resource-object-linkage
 * @see LinkageTest::testCanCreateNullLinkage()
 * @see LinkageTest::testCanCreateEmptyArrayLinkage()
 * @see LinkageTest::testCanCreateFromSingleResourceId()
 * @see LinkageTest::testCanCreateFromArrayOfResourceIds()
 */
class LinkageTest extends TestCase
{
    public function testCanCreateNullLinkage()
    {
        $this->assertEqualsAsJson(
            null,
            Linkage::nullLinkage()
        );
    }

    public function testCanCreateEmptyArrayLinkage()
    {
        $this->assertEqualsAsJson(
            [],
            Linkage::emptyArrayLinkage()
        );
    }

    public function testCanCreateFromSingleResourceId()
    {
        $this->assertEqualsAsJson(
            [
                'type' => 'books',
                'id' => 'abc',
            ],
            Linkage::fromSingleIdentifier(new ResourceIdentifier('books', 'abc'))
        );
    }

    public function testCanCreateFromArrayOfResourceIds()
    {
        $this->assertEqualsAsJson(
            [
                [
                    'type' => 'books',
                    'id' => 'abc',
                ],
                [
                    'type' => 'squirrels',
                    'id' => '123',
                ],
            ],
            Linkage::fromManyIdentifiers(
                new ResourceIdentifier('books', 'abc'),
                new ResourceIdentifier('squirrels', '123')
            )
        );
    }

    public function testNullLinkageIsLinkedToNothing()
    {
        $apple = new ResourceIdentifier('apples', '1');
        $this->assertFalse(Linkage::nullLinkage()->isLinkedTo($apple));
        $this->assertFalse(Linkage::nullLinkage()->isLinkedTo(new NullResource));
    }

    public function testEmptyArrayLinkageIsLinkedToNothing()
    {
        $apple = new ResourceIdentifier('apples', '1');
        $this->assertFalse(Linkage::emptyArrayLinkage()->isLinkedTo($apple));
        $this->assertFalse(Linkage::emptyArrayLinkage()->isLinkedTo(new NullResource));
    }

    public function testSingleLinkageIsLinkedOnlyToItself()
    {
        $apple = new ResourceIdentifier('apples', '1');
        $orange = new ResourceIdentifier('oranges', '1');

        $linkage = Linkage::fromSingleIdentifier($apple);

        $this->assertTrue($linkage->isLinkedTo($apple));
        $this->assertFalse($linkage->isLinkedTo($orange));
    }

    public function testMultiLinkageIsLinkedOnlyToItsMembers()
    {
        $apple = new ResourceIdentifier('apples', '1');
        $orange = new ResourceIdentifier('oranges', '1');
        $banana = new ResourceIdentifier('bananas', '1');

        $linkage = Linkage::fromManyIdentifiers($apple, $orange);

        $this->assertTrue($linkage->isLinkedTo($apple));
        $this->assertTrue($linkage->isLinkedTo($orange));
        $this->assertFalse($linkage->isLinkedTo($banana));
    }
}
