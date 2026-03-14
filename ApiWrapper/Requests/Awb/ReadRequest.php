<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Awb;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Awb
 */
class ReadRequest extends AbstractRequest
{
    protected $endpoint = 'awb/read_pdf';

    /**
     * @return string
     * @throws \Zitec\EmagMarketplace\ApiWrapper\Exceptions\MissingEndpointException
     */
    public function getEndpoint()
    {
        $baseEndpoint = parent::getEndpoint();

        $query = [];

        foreach ($this->requestData['data'] as $k => $v) {
            $query[] = $k . '=' . $v;
        }

        return $baseEndpoint . '?' . implode('&', $query);
    }

    /**
     * @return bool
     */
    public function skipJsonDecode()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function skipLog()
    {
        return true;
    }
}
