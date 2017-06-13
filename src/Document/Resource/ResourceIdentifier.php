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

use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\MetaTrait;
use Lemon\JsonApi\Utility;

/**
 * Class ResourceIdentifier
 *
 * @package Lemon\JsonApi\Document\Resource
 */
class ResourceIdentifier implements ResourceInterface
{
    use MetaTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var null|string
     */
    protected $id;

    /**
     * ResourceIdentifier constructor.
     *
     * @param string $type
     * @param string|null $id
     * @param Meta|null $meta
     */
    public function __construct(string $type, string $id = null, Meta $meta = null)
    {
        $this->type = $type;
        $this->id = $id;

        if ($meta) {
            $this->setMeta($meta);
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("%s:%s", $this->type, $this->id ?? 'null');
    }

    /**
     * Check two resources identifies same object
     *
     * @param ResourceInterface $resource
     * @return bool
     */
    public function identifies(ResourceInterface $resource): bool
    {
        return $resource instanceof self
            && $this->type === $resource->type
            && $this->id !== null
            && $this->id === $resource->id;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter([
            'type' => $this->type,
            'id' => $this->id,
            'meta' => $this->meta,
        ]);
    }
}
