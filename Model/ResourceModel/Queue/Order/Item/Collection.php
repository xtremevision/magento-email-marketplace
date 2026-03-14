<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\OrderQueueItemInterface;
use Zitec\EmagMarketplace\Model\Queue\Order\Item as ItemModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order\Item as ItemResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order\Item
 */
class Collection extends Abstractcollection
{
    protected $_idFieldName = OrderQueueItemInterface::ID;
    
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ItemModel::class, ItemResourceModel::class);
    }
}
