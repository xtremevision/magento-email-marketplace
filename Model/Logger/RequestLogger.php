<?php

namespace Zitec\EmagMarketplace\Model\Logger;

use Zitec\EmagMarketplace\ApiWrapper\Logger\LoggerInterface;

/**
 * Class RequestLogger
 * @package Zitec\EmagMarketplace\Model\Logger
 */
class RequestLogger implements LoggerInterface
{
    /**
     * @var CustomLogger
     */
    protected $logger;

    /**
     * RequestLogger constructor.
     * @param CustomLogger $logger
     */
    public function __construct(CustomLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function log($url, $data, $response, $executionTime = 0, $error = null, $errorNo = null)
    {
        $messageParts = [
            'REQUEST URL: ' . $url,
            'REQUEST DATA: ' . print_r($data, true),
            'EXECUTION TIME: ' . $executionTime,
            'RESPONSE: ' . print_r($response, true),
            'CURL ERROR: ' . print_r($error, true),
            'CURL ERROR NO: ' . print_r($errorNo, true),
            '------------------------------------------',
        ];

        $this->logger->info(implode(PHP_EOL, $messageParts));
    }
}
