<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping as CharacteristicMappingResourceModel;

/**
 * Class CharacteristicMapping
 * @package Zitec\EmagMarketplace\Model
 */
class CharacteristicMapping extends AbstractModel implements CharacteristicMappingInterface
{
    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_init(CharacteristicMappingResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setMappingId(int $id)
    {
        return $this->setData(self::MAPPING_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getMappingId(): int
    {
        return $this->getData(self::MAPPING_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmagCharacteristicId(int $id)
    {
        return $this->setData(self::EMAG_CHARACTERISTIC_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmagCharacteristicId(): int
    {
        return $this->getData(self::EMAG_CHARACTERISTIC_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setMagentoAttributeId(int $id)
    {
        return $this->setData(self::MAGENTO_ATTRIBUTE_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getMagentoAttributeId(): int
    {
        return $this->getData(self::MAGENTO_ATTRIBUTE_ID);
    }
}
