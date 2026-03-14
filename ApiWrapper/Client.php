<?php

namespace Zitec\EmagMarketplace\ApiWrapper;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Client for Emag Marketplace API.
 *
 * Class Client
 * @package Zitec\EmagMarketplace\ApiWrapper
 * @see InstantiableClient
 * @method static sendRequest(AbstractRequest $request)
 * @method static array sendMultiRequest(array $requests)
 */
final class Client
{
    /**
     * @var InstantiableClient
     */
    private static $instance;

    /**
     * Client constructor.
     */
    private function __construct()
    {
    }

    /**
     * @noinspection PhpDocSignatureInspection
     *
     * @param mixed ...$params
     * @return InstantiableClient
     */
    public static function init(... $params)
    {
        // Check if instance is already exists
        if (self::$instance === null) {
            self::$instance = new InstantiableClient(... $params);
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
    }

    /**
     * @param string $method
     * @param array|null $parameters
     * @return array|object|mixed
     */
    public function __call(string $method, array $parameters = [])
    {
        return call_user_func([self::$instance, $method], ...$parameters);
    }

    /**
     * @param string $method
     * @param array|null $parameters
     * @return array|object|mixed
     */
    public static function __callStatic(string $method, array $parameters = [])
    {
        return call_user_func([self::$instance, $method], ...$parameters);
    }
}
