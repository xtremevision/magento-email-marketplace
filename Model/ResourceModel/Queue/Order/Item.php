<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\OrderQueueItemInterface;

/**
 * Class Item
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order
 */
class Item extends AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = OrderQueueItemInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(OrderQueueItemInterface::TABLE, OrderQueueItemInterface::ID);
    }
}
