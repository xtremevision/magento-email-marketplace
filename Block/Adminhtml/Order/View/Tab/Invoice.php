<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Element;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Sales\Model\OrderRepository;
use Zitec\EmagMarketplace\Model\InvoiceRepository;
use Zitec\EmagMarketplace\Model\Json;
use Zitec\EmagMarketplace\Model\OrderAttributes;

/**
 * Class Invoice
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Tab
 */
class Invoice extends Element implements TabInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * Invoice constructor.
     * @param Context $context
     * @param Registry $registry
     * @param InvoiceRepository $invoiceRepository
     * @param OrderRepository $orderRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        InvoiceRepository $invoiceRepository,
        OrderRepository $orderRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->registry = $registry;
        $this->invoiceRepository = $invoiceRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('eMAG Invoice Upload');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('eMAG Invoice Upload');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        $order = $this->registry->registry('current_order');

        return ($order && $order->getId() && $order->getData(OrderAttributes::IS_EMAG_ORDER));
    }

    /**
     * @return string
     */
    public function getAjaxUploadInvoiceUrl()
    {
        return $this->getUrl('emagmarketplace/invoice/upload');
    }

    /**
     * @return string
     */
    public function getCurrentOrderId()
    {
        return $this->getRequest()->getParam('order_id');
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @param string $orderId
     * 
     * @return array|\Zitec\EmagMarketplace\Model\ResourceModel\Invoice\Collection
     * 
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function getUploadedInvoicesByOrderId(string $orderId)
    {
        $order = $this->orderRepository->get($orderId);

        if (!$order->getEntityId() || !$order->getData(OrderAttributes::IS_EMAG_ORDER) || !$order->getData(OrderAttributes::EMAG_ORDER_DATA)) {
            return [];
        }

        $emagOrderData = Json::json_decode($order->getData(OrderAttributes::EMAG_ORDER_DATA), true);

        if (!$emagOrderData || !array_key_exists('id', $emagOrderData)) {
            return [];
        }

        return $this->invoiceRepository->getInvoicesByEmagOrderId($emagOrderData['id']);
    }
}
