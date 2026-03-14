<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\Collection;

/**
 * Interface CategoryRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return CategoryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CategoryInterface;

    /**
     * @return CategoryInterface[]|Collection
     */
    public function getAll(): Collection;

    /**
     * @param array $emagIds
     * @return void
     */
    public function deleteByEmagIds(array $emagIds);
}
