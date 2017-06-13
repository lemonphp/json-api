<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Document\Resource\Relationship;

use Lemon\JsonApi\Document\LinksTrait;
use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\MetaTrait;
use Lemon\JsonApi\Document\Resource\ResourceInterface;
use Lemon\JsonApi\Utility;
use JsonSerializable;

/**
 * Class Relationship
 *
 * @package Lemon\JsonApi\Document\Relationship
 * @see     http://jsonapi.org/format/#document-resource-object-relationships
 */
final class Relationship implements JsonSerializable
{
    use LinksTrait;
    use MetaTrait;

    /**
     * @var Linkage
     */
    private $linkage = null;

    /**
     * Prevents create object by "new" keyword.
     */
    private function __construct()
    {
    }

    /**
     * Make from meta
     *
     * @param Meta $meta
     * @return Relationship
     */
    public static function fromMeta(Meta $meta): self
    {
        $relationship = new self;
        $relationship->setMeta($meta);

        return $relationship;
    }

    /**
     * Make from self link
     *
     * @param string     $link
     * @param array|null $meta
     * @return Relationship
     */
    public static function fromSelfLink(string $link, array $meta = null): self
    {
        $relationship = new self;
        $relationship->setLink('self', $link, $meta);

        return $relationship;
    }

    /**
     * Make from related link
     *
     * @param string     $link
     * @param array|null $meta
     * @return Relationship
     */
    public static function fromRelatedLink(string $link, array $meta = null): self
    {
        $relationship = new self;
        $relationship->setLink('related', $link, $meta);

        return $relationship;
    }

    /**
     * Make from linkage object
     *
     * @param Linkage $linkage
     * @return Relationship
     */
    public static function fromLinkage(Linkage $linkage): self
    {
        $relationship = new self;
        $relationship->linkage = $linkage;

        return $relationship;
    }

    /**
     * @param ResourceInterface $resource
     * @return bool
     */
    public function hasLinkageTo(ResourceInterface $resource): bool
    {
        return ($this->linkage && $this->linkage->isLinkedTo($resource));
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter([
            'data' => $this->linkage,
            'links' => $this->links,
            'meta' => $this->meta,
        ]);
    }
}
