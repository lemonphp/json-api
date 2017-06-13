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

use Generator;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Document\Resource\ResourceInterface;
use JsonSerializable;

/**
 * Class Linkage
 *
 * @package Lemon\JsonApi\Document\Relationship
 * @see     http://jsonapi.org/format/#document-resource-object-linkage
 */
final class Linkage implements JsonSerializable
{
    /**
     * @var array|null|ResourceIdentifier
     */
    private $data;

    /**
     * Prevents create object by "new" keyword.
     */
    private function __construct()
    {
    }

    /**
     * @return Linkage
     */
    public static function nullLinkage(): self
    {
        return new self;
    }

    /**
     * @return Linkage
     */
    public static function emptyArrayLinkage(): self
    {
        $linkage = new self;
        $linkage->data = [];

        return $linkage;
    }

    /**
     * @param ResourceIdentifier $data
     * @return Linkage
     */
    public static function fromSingleIdentifier(ResourceIdentifier $data): self
    {
        $linkage = new self;
        $linkage->data = $data;

        return $linkage;
    }

    /**
     * @param ResourceIdentifier[] $data
     * @return Linkage
     */
    public static function fromManyIdentifiers(ResourceIdentifier ...$data): self
    {
        $linkage = new self;
        $linkage->data = $data;

        return $linkage;
    }

    /**
     * @param ResourceInterface $resource
     * @return bool
     */
    public function isLinkedTo(ResourceInterface $resource): bool
    {
        foreach ($this->toLinkages() as $linkage) {
            if ($linkage->identifies($resource)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Generator
     */
    private function toLinkages(): Generator
    {
        if ($this->data instanceof ResourceIdentifier) {
            yield $this->data;
        } elseif (is_array($this->data)) {
            foreach ($this->data as $resource) {
                yield $resource;
            }
        }
    }

    /**
     * @return array|null|ResourceIdentifier
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
