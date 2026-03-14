<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Invoice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Model\Invoice;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice as InvoiceResource;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Vat
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(Invoice::class, InvoiceResource::class);
    }
}
