<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;
use Zitec\EmagMarketplace\Model\CharacteristicMapping as CharacteristicMappingModel;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping as CharacteristicMappingResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping
 */
class Collection extends Abstractcollection
{
    protected $_idFieldName = CharacteristicMappingInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CharacteristicMappingModel::class, CharacteristicMappingResourceModel::class);
    }
}
