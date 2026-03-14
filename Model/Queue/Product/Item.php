<?php

namespace Zitec\EmagMarketplace\Model\Queue\Product;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item as ItemResourceModel;

/**
 * Class Item
 * @package Zitec\EmagMarketplace\Model\Queue\Product
 */
class Item extends AbstractModel implements ProductQueueItemInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(ItemResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setProductId(int $id)
    {
        return $this->setData(self::PRODUCT_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductId(): int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setAction(string $action)
    {
        return $this->setData(self::ACTION, $action);
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(): string
    {
        return $this->getData(self::ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function setState(string $state)
    {
        return $this->setData(self::STATE, $state);
    }

    /**
     * {@inheritDoc}
     */
    public function getState(): string
    {
        return $this->getData(self::STATE);
    }

    /**
     * {@inheritDoc}
     */
    public function setResponse($response = null)
    {
        return $this->setData(self::RESPONSE, $response);
    }

    /**
     * {@inheritDoc}
     */
    public function getResponse()
    {
        return $this->getData(self::RESPONSE);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
