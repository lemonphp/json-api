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

/**
 * Trait LinksTrait
 *
 * @package Lemon\JsonApi\Document
 */
trait LinksTrait
{
    /**
     * @var array
     */
    protected $links;

    /**
     * @param string          $name
     * @param string          $value
     * @param Meta|array|null $meta
     */
    public function setLink(string $name, string $value, $meta = null)
    {
        if (is_array($meta)) {
            $meta = new Meta($meta);
        }

        $this->links[$name] = new Links($value, $meta);
    }
}
