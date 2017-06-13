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

use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\Resource\Relationship\Linkage;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Tests\TestCase;

/**
 * Relationships
 *
 * The value of the relationships key MUST be an object (a “relationships object”).
 * Members of the relationships object (“relationships”) represent references
 * from the resource object in which it’s defined to other resource objects.
 *
 * Relationships may be to-one or to-many.
 *
 * A “relationship object” MUST contain at least one of the following:
 *
 * - links: a links object containing at least one of the following:
 *      -   self: a link for the relationship itself (a “relationship link”).
 *          This link allows the client to directly manipulate the relationship.
 *          For example, removing an author through an article’s relationship URL would disconnect the person
 *          from the article without deleting the people resource itself. When fetched successfully, this link
 *          returns the linkage for the related resources as its primary data. (See Fetching Relationships.)
 *      -   related: a related resource link
 * - data: resource linkage
 * - meta: a meta object that contains non-standard meta-information about the relationship.
 *
 * A relationship object that represents a to-many relationship MAY also contain
 * pagination links under the links member, as described below.
 *
 * @see http://jsonapi.org/format/#document-resource-object-relationships
 * @see RelationshipTest::testCanCreateFromSelfLink()
 * @see RelationshipTest::testCanCreateFromRelatedLink())
 * @see RelationshipTest::testCanCreateFromLinkage())
 * @see RelationshipTest::testCanCreateFromMeta())
 */
class RelationshipTest extends TestCase
{
    public function testCanCreateFromSelfLink()
    {
        $this->assertEqualsAsJson(
            [
                'links' => [
                    'self' => 'http://localhost',
                ],
            ],
            Relationship::fromSelfLink('http://localhost')
        );
    }

    public function testCanCreateFromRelatedLink()
    {
        $this->assertEqualsAsJson(
            [
                'links' => [
                    'related' => 'http://localhost',
                ],
            ],
            Relationship::fromRelatedLink('http://localhost')
        );
    }

    public function testCanCreateFromLinkage()
    {
        $this->assertEqualsAsJson(
            [
                'data' => null,
            ],
            Relationship::fromLinkage(Linkage::nullLinkage())
        );
    }

    public function testCanCreateFromMeta()
    {
        $this->assertEqualsAsJson(
            [
                'meta' => [
                    'a' => 'b',
                ],
            ],
            Relationship::fromMeta(new Meta(['a' => 'b']))
        );
    }
}
