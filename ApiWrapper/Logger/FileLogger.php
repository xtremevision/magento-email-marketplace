<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Logger;

/**
 * Class FileLogger
 * @package Zitec\EmagMarketplace\ApiWrapper\Logger
 */
class FileLogger implements LoggerInterface
{
    const LOG_PATH = __DIR__ . '/../../logs/';

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

        $message = implode(PHP_EOL, $messageParts);

        file_put_contents(static::LOG_PATH . 'emkp_requests_' . date('Y_m_d') . '.log', $message, FILE_APPEND);
    }
}
