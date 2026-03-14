<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class CreateRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer
 */
class CreateRequest extends AbstractRequest
{
    /**
     * API endpoint
     *
     * @var string
     */
    protected $endpoint = 'product_offer/save';
}
