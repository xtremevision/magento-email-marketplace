<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Order;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class AcknowledgeRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Order
 */
class AcknowledgeRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'order/acknowledge';


    /**
     * Return endpoint URL with order id appended.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint    = parent::getEndpoint();
        $requestData = $this->getRequestData();

        return $endpoint . '/' . $requestData['order_id'];
    }
}
