<?php

namespace Zitec\EmagMarketplace\Observer;

use Magento\Framework\App\State;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Model\Order\Handler;
use Zitec\EmagMarketplace\Model\OrderAttributes;
use Zitec\EmagMarketplace\Model\Queue\Order\Importer;

/**
 * Class AddProductToQueue
 * @package Zitec\EmagMarketplace\Observer
 */
class EditEmagOrderAfter implements ObserverInterface
{
    /**
     * @var State
     */
    protected $state;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Handler
     */
    protected $orderHandler;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * EditEmagOrder constructor.
     * @param State $state
     * @param LoggerInterface $logger
     * @param Handler $orderHandler
     * @param Registry $registry
     */
    public function __construct(
        State $state,
        LoggerInterface $logger,
        Handler $orderHandler,
        Registry $registry
    ) {
        $this->state = $state;
        $this->logger = $logger;
        $this->orderHandler = $orderHandler;
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return bool
     * @throws \Throwable
     */
    public function execute(Observer $observer)
    {
        try {
            $areaCode = $this->state->getAreaCode();
        } catch (LocalizedException $exception) {
            $areaCode = null;
        }

        try {
            $order = $observer->getOrder();

            if ($this->registry->registry(Importer::IMPORTING_ORDER_FLAG) || $this->registry->registry(Handler::AFTER_EDIT_EMAG_ORDER_FLAG)) {
                return true;
            }

            if (!$order->getId() || !$order->getData(OrderAttributes::IS_EMAG_ORDER) || $order->getRelationChildRealId()) {
                return true;
            }

            $this->registry->register(Handler::AFTER_EDIT_EMAG_ORDER_FLAG, 1);
            $this->orderHandler->afterOrderEdit($order);

        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            throw $e;
        }
        return true;
    }
}
