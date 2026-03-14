<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\CategoryRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Category as CategoryResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\CollectionFactory;

/**
 * Class CategoryRepository
 * @package Zitec\EmagMarketplace\Model
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var ResourceModel\Category
     */
    protected $resourceModel;

    /**
     * @var CategoryFactory
     */
    protected $factory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        CategoryFactory $factory,
        CategoryResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->factory = $factory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): CategoryInterface
    {
        /** @var Category $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('eMag Category with id "%1" does not exist.', $id));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return $this->collectionFactory->create()->setOrder('name', 'ASC');
    }

    /**
     * {@inheritDoc}
     */
    public function deleteByEmagIds(array $emagIds)
    {
        $this->collectionFactory->create()
            ->addFieldToFilter('emag_id', ['nin' => $emagIds])
            ->walk('delete');
    }
}
