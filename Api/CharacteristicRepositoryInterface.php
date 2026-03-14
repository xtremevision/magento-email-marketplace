<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic\Collection;

/**
 * Interface CharacteristicRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface CharacteristicRepositoryInterface
{
    /**
     * @param int $id
     * @return CharacteristicInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CharacteristicInterface;

    /**
     * @param CategoryInterface $category
     * @return Collection|CharacteristicInterface[]
     */
    public function getByCategory(CategoryInterface $category): Collection;

    /**
     * @param array $emagIds
     * @return void
     */
    public function deleteByEmagIds(array $emagIds);
}
