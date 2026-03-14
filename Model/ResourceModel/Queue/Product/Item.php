<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;

/**
 * Class Item
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product
 */
class Item extends AbstractDb
{
    protected $_idFieldName = ProductQueueItemInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ProductQueueItemInterface::TABLE, ProductQueueItemInterface::ID);
    }
}
