<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Order;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class AttachmentsRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Order
 */
class AttachmentsRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'order/attachments/save';
}
