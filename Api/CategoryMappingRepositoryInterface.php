<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Exception\DuplicateMappingException;
use Zitec\EmagMarketplace\Exception\MissingRequiredCharacteristicsException;
use Zitec\EmagMarketplace\Model\CategoryMapping;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\Collection;

/**
 * Interface CategoryMappingRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface CategoryMappingRepositoryInterface
{
    /**
     * @param int $id
     * @return CategoryMappingInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * @return Collection|CategoryMapping[]
     */
    public function getAll(): Collection;

    /**
     * @param int|null $id
     * @param int $emagCategoryId
     * @param int $magentoCategoryId
     * @return bool|CategoryMappingInterface
     * @throws DuplicateMappingException
     * @throws MissingRequiredCharacteristicsException
     * @throws NoSuchEntityException
     */
    public function save($id = null, int $emagCategoryId, int $magentoCategoryId);

    /**
     * @param int $id
     * @throws \Exception
     * @return void
     */
    public function deleteById(int $id);

    /**
     * @param int $id
     * @return CategoryMappingInterface
     * @throws NoSuchEntityException
     */
    public function getByMagentoId(int $id);
}
