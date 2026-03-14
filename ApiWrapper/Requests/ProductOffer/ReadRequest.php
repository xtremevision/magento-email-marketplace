<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer
 */
class ReadRequest extends AbstractRequest
{
    /**
     * API Endpoint
     *
     * @var string
     */
    protected $endpoint = 'product_offer/read';
}
