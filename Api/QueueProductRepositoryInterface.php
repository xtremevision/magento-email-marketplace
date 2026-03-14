<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Queue\Product\Item\Collection;

/**
 * Interface QueueProductRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface QueueProductRepositoryInterface
{
    /**
     * @param int $productId
     * @param string $action
     * @return void
     */
    public function insert(int $productId, string $action);

    /**
     * @param int $productId
     * @param array $data
     * @return mixed|void
     */
    public function updateByProductId(int $productId, array $data);

    /**
     * @param int $productId
     * @return AbstractCollection|Collection
     */
    public function getByProductId(int $productId): Collection;

    /**
     * @param int $productId
     * @return void
     */
    public function cancelPendingByProductId(int $productId);

    /**
     * @param string $state
     * @return AbstractCollection|Collection
     */
    public function getByState(string $state): Collection;

    /**
     * @param ProductQueueItemInterface $item
     * @return ProductQueueItemInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(ProductQueueItemInterface $item): ProductQueueItemInterface;
}
