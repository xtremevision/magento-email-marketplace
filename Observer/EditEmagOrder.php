<?php

namespace Zitec\EmagMarketplace\Observer;

use Magento\Framework\App\State;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Model\Order\Handler;
use Zitec\EmagMarketplace\Model\OrderAttributes;
use Zitec\EmagMarketplace\Model\Queue\Order\Importer;

/**
 * Class AddProductToQueue
 * @package Zitec\EmagMarketplace\Observer
 */
class EditEmagOrder implements ObserverInterface
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
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * EditEmagOrder constructor.
     * @param State $state
     * @param LoggerInterface $logger
     * @param Handler $orderHandler
     * @param ManagerInterface $messageManager
     * @param Registry $registry
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        State $state,
        LoggerInterface $logger,
        Handler $orderHandler,
        ManagerInterface $messageManager,
        Registry $registry,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->state = $state;
        $this->logger = $logger;
        $this->orderHandler = $orderHandler;
        $this->messageManager = $messageManager;
        $this->registry = $registry;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Observer $observer
     * @return bool
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        try {
            $areaCode = $this->state->getAreaCode();
        } catch (LocalizedException $exception) {
            $areaCode = null;
        }

        $order = $observer->getOrder();

        if ($this->registry->registry(Importer::IMPORTING_ORDER_FLAG) || $this->registry->registry(Handler::EDITING_EMAG_ORDER_FLAG)) {
            return true;
        }
        
        if($order->getId() && $order->getData(OrderAttributes::IS_EMAG_ORDER)){
            if($order->getRelationChildRealId()){
                return true;
            }

            try {
                $this->orderHandler->beforeSave($order);
            } catch(\Exception $e){
                $this->messageManager->addErrorMessage($e->getMessage());
                throw $e;
            }
        }

        if(!$order->getId() && $order->getRelationParentId()){
            $parentOrder = $this->orderRepository->get($order->getRelationParentId());
            
            if($parentOrder && $parentOrder->getData(OrderAttributes::IS_EMAG_ORDER)){
                try {
                    $this->registry->register(Handler::EDITING_EMAG_ORDER_FLAG,1);
                    
                    $this->orderHandler->beforeSave($order, $parentOrder->getData(OrderAttributes::EMAG_ORDER_DATA));
                } catch(\Exception $e){
                    $this->logger->info($e->getMessage());
                    $this->messageManager->addErrorMessage($e->getMessage());
                    throw $e;
                }
            }
        }

        return true;
    }
}
