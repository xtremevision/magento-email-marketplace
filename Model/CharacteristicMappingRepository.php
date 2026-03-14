<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\CharacteristicMappingRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping as CharacteristicMappingResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping\CollectionFactory;

/**
 * Class CharacteristicMappingRepository
 * @package Zitec\EmagMarketplace\Model
 */
class CharacteristicMappingRepository implements CharacteristicMappingRepositoryInterface
{
    /**
     * @var CharacteristicMappingFactory
     */
    protected $factory;

    /**
     * @var CharacteristicMappingResourceModel
     */
    protected $resourceModel;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        CharacteristicMappingFactory $factory,
        CharacteristicMappingResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->factory = $factory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): CharacteristicMappingInterface
    {
        /** @var CharacteristicMapping $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('eMag Characteristic with id "%1" does not exist.', $id));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteByCategoryMapping(CategoryMappingInterface $categoryMapping)
    {
        $this->collectionFactory->create()
            ->addFieldToFilter('mapping_id', $categoryMapping->getId())
            ->walk('delete');
    }

    /**
     * {@inheritDoc}
     */
    public function saveWithCategoryMapping(
        CategoryMappingInterface $categoryMapping,
        int $characteristicId,
        int $attributeId
    ) {
        /** @var CharacteristicMapping $object */
        $object = $this->factory->create();

        $object->addData([
            'mapping_id' => $categoryMapping->getId(),
            'emag_characteristic_id' => $characteristicId,
            'magento_attribute_id' => $attributeId,
        ]);

        $this->resourceModel->save($object);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getByMapping(CategoryMappingInterface $categoryMapping): Collection
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter('mapping_id', $categoryMapping->getId());
    }
}
