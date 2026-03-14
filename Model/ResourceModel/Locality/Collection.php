<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Locality;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Model\Locality;
use Zitec\EmagMarketplace\Model\ResourceModel\Locality as LocalityResource;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Locality
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Locality::class, LocalityResource::class);
    }
}
