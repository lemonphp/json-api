<?php
/**
 * ResourceFireldsTest.php
 *
 * This source file is part of `lemonphp/json-api` project.
 * It subject to the MIT license that is bundled with this source code in the file LICENSE.
 *
 * @author    Oanh Nguyen <oanhnn.bk@gmail.com>
 * @copyright 2017 LemonPHP Team
 * @license   MIT
 * @see       https://github.com/lemonphp/json-api
 */

namespace Lemon\JsonApi\Tests\Document\Resource;

use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Document\Resource\ResourceObject;
use Lemon\JsonApi\Tests\TestCase;

/**
 * Fields
 *
 * A resource object’s attributes and its relationships are collectively called its “fields”.
 *
 * Fields for a resource object MUST share a common namespace with each other and with type and id.
 * In other words, a resource can not have an attribute and relationship with the same name,
 * nor can it have an attribute or relationship named type or id.
 *
 * @see http://jsonapi.org/format/#document-resource-object-fields
 */
class ResourceFireldsTest extends TestCase
{
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Field foo already exists in attributes
     */
    public function testCanNotSetRelationshipIfAttributeExists()
    {
        $res = new ResourceObject('books', '1');
        $res->setAttribute('foo', 'bar');
        $res->setRelationship('foo', Relationship::fromMeta(new Meta(['a' => 'b'])));
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Field foo already exists in relationships
     */
    public function testCanNotSetAttributeIfRelationshipExists()
    {
        $res = new ResourceObject('books', '1');
        $res->setRelationship('foo', Relationship::fromMeta(new Meta(['a' => 'b'])));
        $res->setAttribute('foo', 'bar');
    }
}
