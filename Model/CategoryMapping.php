<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping as CategoryMappingResourceModel;

/**
 * Class CategoryMapping
 * @package Zitec\EmagMarketplace\Model
 */
class CategoryMapping extends AbstractModel implements CategoryMappingInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CategoryMappingResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmagCategoryId(int $id)
    {
        return $this->setData(self::EMAG_CATEGORY_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmagCategoryId(): int
    {
        return $this->getData(self::EMAG_CATEGORY_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setMagentoCategoryId(int $id)
    {
        return $this->setData(self::MAGENTO_CATEGORY_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getMagentoCategoryId(): int
    {
        return $this->getData(self::MAGENTO_CATEGORY_ID);
    }
}
