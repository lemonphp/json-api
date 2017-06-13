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

use Lemon\JsonApi\Document;
use Lemon\JsonApi\Document\Resource\Relationship\Linkage;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Document\Resource\ResourceObject;

/**
 * Class IntegrationTest
 *
 * @package Lemon\JsonApi\Tests
 */
class IntegrationTest extends TestCase
{
    public function testFromTheReadmeFile()
    {
        $json = <<<JSON
{
    "data": {
        "type": "articles",
        "id": "1",
        "attributes": {
            "title": "Rails is Omakase"
        },
        "relationships": {
            "author": {
                "data": {
                    "type": "people",
                    "id": "9"
                },
                "links": {
                    "self": "\/articles\/1\/relationships\/author",
                    "related": "\/articles\/1\/author"
                }
            }
        }
    }
}
JSON;

        $articles = new ResourceObject('articles', '1');
        $author = Relationship::fromLinkage(
            Linkage::fromSingleIdentifier(
                new ResourceIdentifier('people', '9')
            )
        );
        $author->setLink('self', '/articles/1/relationships/author');
        $author->setLink('related', '/articles/1/author');
        $articles->setRelationship('author', $author);
        $articles->setAttribute('title', 'Rails is Omakase');
        $doc = Document::fromResource($articles);

        $this->assertEquals(
            $json,
            json_encode($doc, JSON_PRETTY_PRINT)
        );
    }
}
