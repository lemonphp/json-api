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
 * Class Error
 *
 * @package Lemon\JsonApi\Document
 * @see     http://jsonapi.org/format/#error-objects
 */
final class Error implements JsonSerializable
{
    use MetaTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $links;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var array
     */
    private $source;

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $link
     */
    public function setAboutLink(string $link)
    {
        $this->links['about'] = $link;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $detail
     */
    public function setDetail(string $detail)
    {
        $this->detail = $detail;
    }

    /**
     * @param string $pointer
     */
    public function setSourcePointer(string $pointer)
    {
        $this->source['pointer'] = $pointer;
    }

    /**
     * @param string $parameter
     */
    public function setSourceParameter(string $parameter)
    {
        $this->source['parameter'] = $parameter;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return Utility::arrayFilter([
            'id' => $this->id,
            'links' => $this->links,
            'status' => $this->status,
            'code' => $this->code,
            'title' => $this->title,
            'detail' => $this->detail,
            'source' => $this->source,
            'meta' => $this->meta,
        ]);
    }
}
