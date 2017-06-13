# lemonphp/json-api

[![Build Status](https://travis-ci.org/lemonphp/json-api.svg?branch=master)](https://travis-ci.org/lemonphp/json-api)
[![Coverage Status](https://coveralls.io/repos/github/lemonphp/json-api/badge.svg?branch=master)](https://coveralls.io/github/lemonphp/json-api?branch=master)

A PHP7 implement of [JSON API specification](http://jsonapi.org/)

## Requirements

* php >= 7.0

## Installation

```bash
$ composer require lemonphp/json-api
```

## Usage

Example code:

```php
<?php

use Lemon\JsonApi\Document;
use Lemon\JsonApi\Document\Resource\Relationship\Linkage;
use Lemon\JsonApi\Document\Resource\Relationship\Relationship;
use Lemon\JsonApi\Document\Resource\ResourceIdentifier;
use Lemon\JsonApi\Document\Resource\ResourceObject;

include_once 'vendor/autoload.php';

$author = Relationship::fromLinkage(
    Linkage::fromSingleIdentifier(
        new ResourceIdentifier('people', '9')
    )
);
$author->setLink('self', '/articles/1/relationships/author');
$author->setLink('related', '/articles/1/author');

$article = new ResourceObject('articles', '1');
$article->setAttribute('title', 'Hello word');
$article->setRelationship('author', $author);

$doc = Document::fromResource($article);
echo json_encode($doc, JSON_PRETTY_PRINT);

```

Output:

```json
{
    "data": {
        "type": "articles",
        "id": "1",
        "attributes": {
            "title": "Hello word"
        },
        "relationships": {
            "author": {
                "data": {
                    "type": "people",
                    "id": "9"
                },
                "links": {
                    "self": "\/articles\/1\/relationships\/author",
                    "related": "\/articles\/1\/author"
                }
            }
        }
    }
}
```

## Changelog

See all change logs in [CHANGELOG.md][changelog]

## Contributing

All code contributions must go through a pull request and approved by
a core developer before being merged. This is to ensure proper review of all the code.

Fork the project, create a feature branch, and send a pull request.

To ensure a consistent code base, you should make sure the code follows the [PSR-2][psr2].

If you would like to help take a look at the [list of issues][issues].

## License

This project is released under the MIT License.   
Copyright © 2017 LemonPHP Team.


[changelog]: https://github.com/lemonphp/json-api/blob/master/CHANGELOG.md
[psr2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[issues]: https://github.com/lemonphp/json-api/issues