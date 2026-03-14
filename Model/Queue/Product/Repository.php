<?php

namespace Zitec\EmagMarketplace\Model\Queue\Product;

use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;
use Zitec\EmagMarketplace\Api\QueueProductRepositoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item as ItemResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item\CollectionFactory;

/**
 * Class Repository
 * @package Zitec\EmagMarketplace\Model\Queue\Product
 */
class Repository implements QueueProductRepositoryInterface
{
    /**
     * @var ItemFactory
     */
    protected $factory;

    /**
     * @var ItemResourceModel
     */
    protected $resouceModel;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        ItemFactory $factory,
        ItemResourceModel $resouceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->factory = $factory;
        $this->resouceModel = $resouceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function insert(int $productId, string $action)
    {
        /** @var Item $object */
        $object = $this->factory->create();

        $object->setProductId($productId);
        $object->setAction($action);

        $this->resouceModel->save($object);
    }

    /**
     * {@inheritDoc}
     */
    public function updateByProductId(int $productId, array $data)
    {
        $items = $this->getByProductId($productId);

        /** @var Item $item */
        foreach ($items as $item) {
            $item->addData($data);
        }
        $items->save();
    }

    /**
     * {@inheritDoc}
     */
    public function getByProductId(int $productId): Collection
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(ProductQueueItemInterface::PRODUCT_ID, $productId);
    }

    /**
     * {@inheritDoc}
     */
    public function cancelPendingByProductId(int $productId)
    {
        $items = $this->getByProductId($productId)
            ->addFieldToFilter(ProductQueueItemInterface::STATE, ProductQueueItemInterface::STATE_PENDING);

        /** @var Item $item */
        foreach ($items as $item) {
            $item->addData([
                ProductQueueItemInterface::STATE => ProductQueueItemInterface::STATE_CANCELLED,
            ]);
        }

        $items->save();
    }

    /**
     * {@inheritDoc}
     */
    public function getByState(string $state): Collection
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(ProductQueueItemInterface::STATE, $state);
    }

    /**
     * {@inheritDoc}
     */
    public function save(ProductQueueItemInterface $item): ProductQueueItemInterface
    {
        $this->resouceModel->save($item);

        return $item;
    }
}
