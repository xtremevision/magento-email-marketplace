<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\InvoiceInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice as ResourceInvoice;

/**
 * Class Invoice
 * @package Zitec\EmagMarketplace\Model
 */
class Invoice extends AbstractModel implements InvoiceInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceInvoice::class);
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
    public function getEmagOrderId(): int
    {
        return $this->getData(self::EMAG_ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmagOrderId(int $emagOrderId)
    {
        return $this->setData(self::EMAG_ORDER_ID, $emagOrderId);
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return $this->getData(self::PATH);
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(string $path)
    {
        return $this->setData(self::PATH, $path);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(): string
    {
        return $this->getData(self::URL);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl(string $url)
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * {@inheritdoc}
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
}
