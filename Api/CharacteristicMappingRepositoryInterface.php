<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping\Collection;

/**
 * Interface CharacteristicMappingRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface CharacteristicMappingRepositoryInterface
{
    /**
     * @param int $id
     * @return CharacteristicMappingInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CharacteristicMappingInterface;

    /**
     * @param CategoryMappingInterface $categoryMapping
     * @return void
     */
    public function deleteByCategoryMapping(CategoryMappingInterface $categoryMapping);

    /**
     * @param CategoryMappingInterface $categoryMapping
     * @param int $characteristicId
     * @param int $attributeId
     * @return bool
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function saveWithCategoryMapping(
        CategoryMappingInterface $categoryMapping,
        int $characteristicId,
        int $attributeId
    );

    /**
     * @param CategoryMappingInterface $categoryMapping
     * @return Collection|CharacteristicMappingInterface[]
     */
    public function getByMapping(CategoryMappingInterface $categoryMapping): Collection;
}
