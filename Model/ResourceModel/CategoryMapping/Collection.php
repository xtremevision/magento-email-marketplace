<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Model\CategoryMapping as CategoryMappingModel;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping as CategoryMappingResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = CategoryMappingInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CategoryMappingModel::class, CategoryMappingResourceModel::class);
    }
}
