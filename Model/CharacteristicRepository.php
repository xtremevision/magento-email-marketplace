<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\CharacteristicRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic as CharacteristicResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic\Collection as CollectionData;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic\CollectionFactory;

/**
 * Class CharacteristicRepository
 * @package Zitec\EmagMarketplace\Model
 */
class CharacteristicRepository implements CharacteristicRepositoryInterface
{
    /**
     * @var CharacteristicFactory
     */
    protected $factory;

    /**
     * @var Characteristic
     */
    protected $resourceModel;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        CharacteristicFactory $factory,
        CharacteristicResourceModel $resourceModel,
        Collection $collection,
        CollectionFactory $collectionFactory
    ) {
        $this->factory = $factory;
        $this->resourceModel = $resourceModel;
        $this->collection = $collection;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): CharacteristicInterface
    {
        /** @var Characteristic $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Characteristic with id "%1" does not exist.', $id));
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategory(CategoryInterface $category): CollectionData
    {
        return $this->collectionFactory->create()->addFieldToFilter('category_emag_id', $category->getEmagId());
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
