<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;

/**
 * Class CategoryMapping
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class CategoryMapping extends AbstractDb
{
    protected $_idFieldName = CategoryMappingInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CategoryMappingInterface::TABLE, CategoryMappingInterface::ID);
    }
}
