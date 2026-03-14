<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Category as CategoryResourceModel;

/**
 * Class Category
 * @package Zitec\EmagMarketplace\Model
 */
class Category extends AbstractModel implements CategoryInterface
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(CategoryResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmagId(int $emagId)
    {
        return $this->setData(self::EMAG_ID, $emagId);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmagId(): int
    {
        return $this->getData(self::EMAG_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsEanMandatory(bool $isEanMandatory)
    {
        return $this->setData(self::IS_EAN_MANDATORY, $isEanMandatory);
    }

    /**
     * {@inheritDoc}
     */
    public function isEanMandatory(): bool
    {
        return $this->getData(self::IS_EAN_MANDATORY);
    }
}
