<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Awb;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\AwbInterface;
use Zitec\EmagMarketplace\Model\Awb as AwbModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Awb as AwbResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Awb
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = AwbInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(AwbModel::class, AwbResourceModel::class);
    }
}
