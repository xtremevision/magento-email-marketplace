<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Model\HandlingTime;
use Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime as HandlingTimeResource;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(
            HandlingTime::class,
            HandlingTimeResource::class
        );
    }
}
