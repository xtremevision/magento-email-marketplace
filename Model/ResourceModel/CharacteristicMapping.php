<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;

/**
 * Class CharacteristicMapping
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class CharacteristicMapping extends AbstractDb
{
    protected $_idFieldName = CharacteristicMappingInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CharacteristicMappingInterface::TABLE, CharacteristicMappingInterface::ID);
    }
}
