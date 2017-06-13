<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi\Document;

use Lemon\JsonApi\Utility;
use JsonSerializable;

/**
 * Class Meta
 *
 * @package Lemon\JsonApi\Document
 * @see     http://jsonapi.org/format/#document-meta
 */
final class Meta implements JsonSerializable
{
    /**
     * @var array
     */
    private $data;

    /**
     * Meta constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter($this->data);
    }
}
