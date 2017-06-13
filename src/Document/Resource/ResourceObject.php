<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Document\Resource;

use InvalidArgumentException;
use Lemon\JsonApi\Document\LinksTrait;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Utility;
use LogicException;

/**
 * Class ResourceObject
 *
 * @package Lemon\JsonApi\Document\Resource
 */
final class ResourceObject extends ResourceIdentifier
{
    use LinksTrait;

    /**
     * @var array|null
     */
    private $attributes;

    /**
     * @var array|null
     */
    private $relationships;

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setAttribute(string $name, $value)
    {
        if (in_array($name, ['id', 'type'])) {
            throw new InvalidArgumentException('Invalid attribute name');
        }

        if (isset($this->relationships[$name])) {
            throw new LogicException("Field $name already exists in relationships");
        }

        $this->attributes[$name] = $value;
    }

    /**
     * @param string        $name
     * @param Relationship  $relationship
     */
    public function setRelationship(string $name, Relationship $relationship)
    {
        if (isset($this->attributes[$name])) {
            throw new LogicException("Field $name already exists in attributes");
        }

        $this->relationships[$name] = $relationship;
    }

    /**
     * @return ResourceIdentifier
     */
    public function toId(): ResourceIdentifier
    {
        return new ResourceIdentifier($this->type, $this->id);
    }

    /**
     * Check two resources identifies same object
     *
     * @param ResourceInterface $resource
     * @return bool
     */
    public function identifies(ResourceInterface $resource): bool
    {
        if ($this->relationships) {
            /** @var Relationship $relationship */
            foreach ($this->relationships as $relationship) {
                if ($relationship->hasLinkageTo($resource)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter([
            'type' => $this->type,
            'id' => $this->id,
            'attributes' => $this->attributes,
            'relationships' => $this->relationships,
            'links' => $this->links,
            'meta' => $this->meta,
        ]);
    }
}
