<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Order;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Order
 */
class ReadRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'order/read';
}
