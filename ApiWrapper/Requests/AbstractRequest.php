<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests;

use Zitec\EmagMarketplace\ApiWrapper\Exceptions\MissingEndpointException;

/**
 * This is the base class for requests to Emag Marketplace.
 * All other request classes MUST extend this one.
 */
abstract class AbstractRequest
{
    /**
     * Resource path
     *
     * @var string
     */
    protected $endpoint;

    /**
     * Request data
     *
     * @var array
     */
    protected $requestData = [];

    /**
     * Zitec_MkpApiWrapper_Requests_AbstractRequest constructor.
     *
     * @param array $requestData
     */
    public function __construct(array $requestData = [])
    {
        $this->setRequestData($requestData);
    }

    /**
     * @throws MissingEndpointException
     * @return string
     */
    public function getEndpoint()
    {
        if (!$this->endpoint) {
            throw new MissingEndpointException('Endpoint not defined for request ' . static::class);
        }

        return $this->endpoint;
    }

    /**
     * @param array $requestData
     *
     * @return $this
     */
    public function setRequestData(array $requestData)
    {
        $this->requestData = [
            'data' => $requestData
        ];

        return $this;
    }

    /**
     * @param bool $excludeDataKey
     *
     * @return array
     */
    public function getRequestData($excludeDataKey = true)
    {
        if (!$excludeDataKey) {
            return $this->requestData;
        }

        return $this->requestData['data'];
    }

    /**
     * @return bool
     */
    public function skipJsonDecode()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function skipLog()
    {
        return false;
    }
}
