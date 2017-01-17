<?php

namespace Vulcan\Collections\Support;

class Arr
{
    /**
     * Get an item from an array with dot notation support.
     *
     * @param  array  $array
     * @param  mixed  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get(array $array, $key = null, $default = null)
    {
        if (is_null($key)) return null;

        if (isset($array[$key])) return $array[$key];

        foreach(explode('.', $key) as $token) {
            if (! is_array($array) or ! array_key_exists($token, $array)) {
                return $default;
            }

            $array = $array[$token];
        }

        return $array;
    }
}
