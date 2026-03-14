<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;
use Zitec\EmagMarketplace\Model\Queue\Product\Item as ItemModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item as ItemResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item
 */
class Collection extends Abstractcollection
{
    protected $_idFieldName = ProductQueueItemInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ItemModel::class, ItemResourceModel::class);
    }
}
