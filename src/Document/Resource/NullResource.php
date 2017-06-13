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

/**
 * Class NullResource
 *
 * @package Lemon\JsonApi\Document\Resource
 */
final class NullResource implements ResourceInterface
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'null';
    }

    /**
     * Check two resources identifies same object
     *
     * @param ResourceInterface $resource
     * @return bool
     */
    public function identifies(ResourceInterface $resource): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return null;
    }
}
