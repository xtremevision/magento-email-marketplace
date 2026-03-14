<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic as CharacteristicResourceModel;

/**
 * Class Characteristic
 * @package Zitec\EmagMarketplace\Model
 */
class Characteristic extends AbstractModel implements CharacteristicInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CharacteristicResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmagId(int $emagId)
    {
        return $this->setData(self::EMAG_ID, $emagId);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmagId(): int
    {
        return $this->getData(self::EMAG_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name = null)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setValues($values = null)
    {
        return $this->setData(self::VALUES, $values);
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        return $this->getData(self::VALUES);
    }

    /**
     * {@inheritDoc}
     */
    public function setAllowNewValue(bool $allowNewValue)
    {
        return $this->setData(self::ALLOW_NEW_VALUE, $allowNewValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowNewValue(): bool
    {
        return $this->getData(self::ALLOW_NEW_VALUE);
    }

    /**
     * {@inheritDoc}
     */
    public function setCategoryEmagId(int $id)
    {
        return $this->setData(self::CATEGORY_EMAG_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryEmagId(): int
    {
        return $this->getData(self::CATEGORY_EMAG_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsMandatory(bool $isMandatory)
    {
        return $this->setData(self::IS_MANDATORY, $isMandatory);
    }

    /**
     * {@inheritDoc}
     */
    public function isMandatory(): bool
    {
        return $this->getData(self::IS_MANDATORY);
    }
}
