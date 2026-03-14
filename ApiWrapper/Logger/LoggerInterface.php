<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Logger;

interface LoggerInterface
{
    /**
     * @param mixed $url
     * @param mixed $data
     * @param mixed $response
     * @param mixed $executionTime
     * @param mixed $error
     * @param mixed $errorNo
     * @return void
     */
    public function log($url, $data, $response, $executionTime = 0, $error = null, $errorNo = null);
}
