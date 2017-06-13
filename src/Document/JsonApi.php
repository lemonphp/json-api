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

use JsonSerializable;
use Lemon\JsonApi\Utility;

/**
 * Class JsonApi
 *
 * @package Lemon\JsonApi\Document
 * @see http://jsonapi.org/format/#document-jsonapi-object
 */
class JsonApi implements JsonSerializable
{
    use MetaTrait;

    /**
     * @var string
     */
    private $version = '1.0';

    /**
     * JsonApi constructor.
     *
     * @param string $version
     * @param Meta   $meta
     */
    public function __construct(string $version = '1.0', Meta $meta = null)
    {
        $this->version = $version;

        if ($meta) {
            $this->setMeta($meta);
        }
    }

    /**
     * @return null|Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter([
            'version' => $this->version,
            'meta' => $this->meta,
        ]);
    }
}
