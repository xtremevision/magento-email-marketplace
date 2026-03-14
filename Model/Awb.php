<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\AwbInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Awb as AwbResourceModel;

/**
 * Class Awb
 * @package Zitec\EmagMarketplace\Model
 */
class Awb extends AbstractModel implements AwbInterface
{
    /**
     * @var array
     */
    public static $sizes = [
        'A4',
        'A5',
        'A6',
    ];

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(AwbResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmagId(int $id)
    {
        return $this->setData(self::EMAG_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmagId()
    {
        return $this->getData(self::EMAG_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setOrderId(int $id)
    {
        return $this->setData(self::ORDER_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setCourierName(string $name)
    {
        return $this->setData(self::COURIER_NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getCourierName()
    {
        return $this->getData(self::COURIER_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setAwbNumber(string $number)
    {
        return $this->setData(self::AWB_NUMBER, $number);
    }

    /**
     * {@inheritDoc}
     */
    public function getAwbNumber()
    {
        return $this->getData(self::AWB_NUMBER);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
}
