<?php

namespace Zitec\EmagMarketplace\Controller\Order;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Api\Data\OrderQueueItemInterface;
use Zitec\EmagMarketplace\Api\QueueOrderRepositoryInterface;

/**
 * Class Ping
 * @package Zitec\EmagMarketplace\Controller\Order
 */
class Ping extends Action
{
    /**
     * @var QueueOrderRepositoryInterface
     */
    protected $repository;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Ping constructor.
     *
     * @param Context $context
     * @param QueueOrderRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        QueueOrderRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);

        $this->repository = $repository;
        $this->logger     = $logger;
    }

    /**
     * Add new eMAG order id in order import queue
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        if (!$orderId || !is_numeric($orderId)) {
            return;
        }

        $orderId = (int)$orderId;
        
        $existingItem = $this->repository->getByEmagId($orderId);

        if (!$existingItem->getSize()) {
            try {
                $this->repository->insert($orderId, OrderQueueItemInterface::STATUS_PENDING);
            } catch (\Exception $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
