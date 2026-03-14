<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Characteristic;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\Model\Characteristic as CharacteristicModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic as CharacteristicResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Characteristic
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = CharacteristicInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CharacteristicModel::class, CharacteristicResourceModel::class);
    }
}
