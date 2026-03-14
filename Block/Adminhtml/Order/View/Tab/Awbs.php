<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Tab;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Grid\Container;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Registry;
use Zitec\EmagMarketplace\Model\OrderAttributes;

/**
 * Class Awbs
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Tab
 */
class Awbs extends Container implements TabInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Awbs constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(Context $context, Registry $registry, array $data = [])
    {
        parent::__construct($context, $data);

        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('eMAG AWBs');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Order Awbs');
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
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
