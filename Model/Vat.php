<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\VatInterface;

/**
 * Class Vat
 * @package Zitec\EmagMarketplace\Model
 */
class Vat extends AbstractModel implements VatInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Zitec\EmagMarketplace\Model\ResourceModel\Vat');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmagId(): int
    {
        return $this->getData(self::EMAG_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmagId(int $emagId)
    {
        return $this->setData(self::EMAG_ID, $emagId);
    }

    /**
     * {@inheritdoc}
     */
    public function getVatRate(): float
    {
        return $this->getData(self::VAT_RATE);
    }

    /**
     * {@inheritdoc}
     */
    public function setVatRate(float $vatRate)
    {
        return $this->setData(self::VAT_RATE, $vatRate);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsDefault(): bool
    {
        return $this->getData(self::IS_DEFAULT);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsDefault(bool $isDefault)
    {
        return $this->setData(self::IS_DEFAULT, $isDefault);
    }
}
