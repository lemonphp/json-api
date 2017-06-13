<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Lemon\JsonApi\Document;
use Lemon\JsonApi\Document\Resource\Relationship\Linkage;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Document\Resource\ResourceObject;

include_once 'vendor/autoload.php';

$author = Relationship::fromLinkage(
    Linkage::fromSingleIdentifier(
        new ResourceIdentifier('people', '9')
    )
);
$author->setLink('self', '/articles/1/relationships/author');
$author->setLink('related', '/articles/1/author');

$article = new ResourceObject('articles', '1');
$article->setAttribute('title', 'Rails is Omakase');
$article->setRelationship('author', $author);

$doc = Document::fromResource($article);
echo json_encode($doc, JSON_PRETTY_PRINT);
