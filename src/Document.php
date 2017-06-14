<?php
/*
 * This file is part of `lemonphp/json-api` project.
 *
 * (c) 2017 LemonPHP Team
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lemon\JsonApi;

use Generator;
use Lemon\JsonApi\Document\Error;
use Lemon\JsonApi\Document\JsonApi;
use Lemon\JsonApi\Document\LinksTrait;
use Lemon\JsonApi\Document\Meta;
use Lemon\JsonApi\Document\MetaTrait;
use Lemon\JsonApi\Document\Resource\ResourceInterface;
use Lemon\JsonApi\Document\Resource\ResourceObject;
use JsonSerializable;
use LogicException;

/**
 * Class Document
 *
 * @package Lemon\JsonApi
 * @see     http://jsonapi.org/format/#document-structure
 */
class Document implements JsonSerializable
{
    use LinksTrait;
    use MetaTrait;

    const MEDIA_TYPE = 'application/vnd.api+json';
    const DEFAULT_API_VERSION = '1.0';

    /**
     * @var null|ResourceInterface|ResourceInterface[]
     */
    private $data;

    /**
     * @var null|Error[]
     */
    private $errors;

    /**
     * @var null|JsonApi
     */
    private $api;

    /**
     * @var null|ResourceObject[]
     */
    private $included;

    /**
     * @var bool
     */
    private $isSparse = false;

    /**
     * Prevents create object by "new" keyword.
     */
    private function __construct()
    {
    }

    /**
     * @param Meta $meta
     * @return Document
     */
    public static function fromMeta(Meta $meta): self
    {
        $doc = new self;
        $doc->setMeta($meta);

        return $doc;
    }

    /**
     * @param Error[] $errors
     * @return Document
     */
    public static function fromErrors(Error ...$errors): self
    {
        $doc = new self;
        $doc->errors = $errors;

        return $doc;
    }

    /**
     * @param ResourceInterface $data
     * @return Document
     */
    public static function fromResource(ResourceInterface $data): self
    {
        $doc = new self;
        $doc->data = $data;

        return $doc;
    }

    /**
     * @param ResourceInterface[] $data
     * @return Document
     */
    public static function fromResources(ResourceInterface ...$data): self
    {
        $doc = new self;
        $doc->data = $data;

        return $doc;
    }

    /**
     * @param string $version
     */
    public function setApiVersion(string $version = self::DEFAULT_API_VERSION)
    {
        $meta = null;
        if (null !== $this->api) {
            $meta = $this->api->getMeta();
        }

        $this->api = new JsonApi($version, $meta);
    }

    /**
     * @param array $meta
     */
    public function setApiMeta(array $meta)
    {
        if (null === $this->api) {
            $this->api = new JsonApi(self::DEFAULT_API_VERSION);
        }

        $this->api->setMeta(new Meta($meta));
    }

    /**
     * @param ResourceObject[] $included
     */
    public function setIncluded(ResourceObject ...$included)
    {
        $this->included = $included;
    }

    /**
     * Mark document use spare fieldsets
     *
     * @see http://jsonapi.org/format/#fetching-sparse-fieldsets
     */
    public function markSparse()
    {
        $this->isSparse = true;
    }

    /**
     * @return void
     * @throws LogicException
     * @see http://jsonapi.org/format/#document-compound-documents
     */
    private function enforceFullLinkage()
    {
        if ($this->isSparse || empty($this->included)) {
            return;
        }
        foreach ($this->included as $includedResource) {
            if ($this->hasLinkTo($includedResource) || $this->anotherIncludedResourceIdentifies($includedResource)) {
                continue;
            }
            throw new LogicException("Full linkage is required for {$includedResource}");
        }
    }

    /**
     * @param ResourceObject $resource
     * @return bool
     */
    private function anotherIncludedResourceIdentifies(ResourceObject $resource): bool
    {
        /** @var ResourceObject $includedResource */
        foreach ($this->included as $includedResource) {
            if ($includedResource !== $resource && $includedResource->identifies($resource)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ResourceObject $resource
     * @return bool
     */
    private function hasLinkTo(ResourceObject $resource): bool
    {
        /** @var ResourceInterface $dataResource */
        foreach ($this->toResources() as $dataResource) {
            if ($dataResource->identifies($resource)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Generator
     */
    private function toResources(): Generator
    {
        if ($this->data instanceof ResourceInterface) {
            yield $this->data;
        } elseif (is_array($this->data)) {
            foreach ($this->data as $datum) {
                yield $datum;
            }
        }
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        $this->enforceFullLinkage();

        return Utility::arrayFilter([
            'data' => $this->data,
            'errors' => $this->errors,
            'meta' => $this->meta,
            'jsonapi' => $this->api,
            'links' => $this->links,
            'included' => $this->included,
        ]);
    }
}
