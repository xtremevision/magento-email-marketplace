<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\CategoryMappingRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Exception\DuplicateMappingException;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping as CategoryMappingResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\CollectionFactory;

/**
 * Class CategoryMappingRepository
 * @package Zitec\EmagMarketplace\Model
 */
class CategoryMappingRepository implements CategoryMappingRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    protected $factory;

    /**
     * {@inheritDoc}
     */
    protected $resourceModel;

    /**
     * {@inheritDoc}
     */
    protected $collectionFactory;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        CategoryMappingFactory $factory,
        CategoryMappingResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->factory = $factory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): CategoryMappingInterface
    {
        /** @var CategoryMapping $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Category Mapping with id "%1" does not exist.', $id));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     * {@inheritDoc}
     */
    public function getByMagentoId(int $magentoCategoryId)
    {
        /** @var CategoryMapping $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $magentoCategoryId, CategoryMappingInterface::MAGENTO_CATEGORY_ID);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with magento id "%1" does not exist.', $magentoCategoryId));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function save($id = null, int $emagCategoryId, int $magentoCategoryId)
    {
        /** @var CategoryMapping $mapping */
        $mapping = $this->factory->create();

        try {
            $mappingWithMagentoId = $this->getByMagentoId($magentoCategoryId);
            if ($mappingWithMagentoId->getId() != $id) {
                throw new DuplicateMappingException(__('Duplicate mapping with Magento category id "%1".',
                    $magentoCategoryId));
            }
        } catch (NoSuchEntityException $exception) {
        }

        if ($id) {
            try {
                $mapping = $this->getById($id);
            } catch (\Throwable $exception) {
            }
        }

        $mapping->setEmagCategoryId($emagCategoryId);
        $mapping->setMagentoCategoryId($magentoCategoryId);

        try {
            $this->resourceModel->save($mapping);

            return $mapping;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $id)
    {
        /** @var CategoryMapping $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        $this->resourceModel->delete($object);
    }
}
