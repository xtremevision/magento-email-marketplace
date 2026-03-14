<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Vat;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Model\ResourceModel\Vat as VatResource;
use Zitec\EmagMarketplace\Model\Vat;

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
        $this->_init(Vat::class, VatResource::class);
    }
}
