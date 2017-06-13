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
 * Trait MetaTrait
 *
 * @package Lemon\JsonApi\Document
 */
trait MetaTrait
{
    /**
     * @var Meta
     */
    protected $meta;

    /**
     * @param Meta $meta
     */
    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }
}
