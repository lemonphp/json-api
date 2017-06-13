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

/**
 * Class Utility
 *
 * @package JsonApi
 */
class Utility
{
    /**
     * @param array $array
     * @return object
     */
    public static function arrayFilter(array $array)
    {
        return (object) array_filter(
            $array,
            function ($v) {
                return null !== $v;
            }
        );
    }

    /**
     * Check string is valid member name
     *
     * @param $name
     * @return bool
     * @see http://jsonapi.org/format/#document-member-names
     */
    public static function validMemberName($name)
    {
        // TODO: implement method
        return true;
    }
}
