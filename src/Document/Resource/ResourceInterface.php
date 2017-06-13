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

use JsonSerializable;

/**
 * Interface ResourceInterface
 *
 * @package Lemon\JsonApi\Document\Resource
 */
interface ResourceInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * Check two resources identifies same object
     *
     * @param ResourceInterface $resource
     * @return bool
     */
    public function identifies(ResourceInterface $resource): bool;
}
