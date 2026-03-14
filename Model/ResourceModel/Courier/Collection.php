<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Courier;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Model\Courier;
use Zitec\EmagMarketplace\Model\ResourceModel\Courier as CourierResource;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Courier
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(
            Courier::class,
            CourierResource::class
        );
    }
}
