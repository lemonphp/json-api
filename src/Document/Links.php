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

/**
 * Class Links
 *
 * @package Lemon\JsonApi\Document
 * @see     http://jsonapi.org/format/#document-links
 */
final class Links implements JsonSerializable
{
    use MetaTrait;

    /**
     * @var string
     */
    private $href;

    /**
     * Links constructor.
     *
     * @param string $href
     * @param null|Meta $meta
     */
    public function __construct(string $href, Meta $meta = null)
    {
        $this->href = $href;

        if ($meta) {
            $this->setMeta($meta);
        }
    }

    /**
     * @return object|string
     */
    public function jsonSerialize()
    {
        return is_null($this->meta) ? $this->href : (object) [
            'href' => $this->href,
            'meta' => $this->meta,
        ];
    }
}
