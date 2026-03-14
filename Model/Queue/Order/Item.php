<?php

namespace Zitec\EmagMarketplace\Model\Queue\Order;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\OrderQueueItemInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Order\Item as ItemResourceModel;

/**
 * Class Item
 * @package Zitec\EmagMarketplace\Model\Queue\Order
 */
class Item extends AbstractModel implements OrderQueueItemInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ItemResourceModel::class);
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
    public function getMagentoId(): string
    {
        return $this->getData(self::MAGENTO_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setMagentoId(string $magentoId)
    {
        return $this->setData(self::MAGENTO_ID, $magentoId);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage(string $message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
