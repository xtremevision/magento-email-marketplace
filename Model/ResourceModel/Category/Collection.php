<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Model\Category as CategoryModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Category as CategoryResourceModel;

/**
 * Class Collection
 * @package Zitec\EmagMarketplace\Model\ResourceModel\Category
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = CategoryInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CategoryModel::class, CategoryResourceModel::class);
    }
}
