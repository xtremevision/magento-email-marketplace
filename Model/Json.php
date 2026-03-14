<?php

namespace Zitec\EmagMarketplace\Model;

/**
 * Class Json
 * @package Zitec\EmagMarketplace\Model
 */
final class Json
{
    const JSON_ERROR_NONE = 0;

    /**
     * @param mixed $json
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     */
    public static function json_decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        $data = \json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }

    /**
     * @param mixed $value
     * @param int $options
     * @param int $depth
     * @return string
     */
    public static function json_encode($value, $options = 0, $depth = 512)
    {
        $json = \json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_encode error: ' . json_last_error_msg()
            );
        }

        return $json;
    }
}