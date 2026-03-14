<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Zitec\EmagMarketplace\Model\OrderAttributes;

/**
 * Class GenerateAwb
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Button
 */
class GenerateAwb implements ButtonProviderInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var UrlInterface
     */
    protected $urlBuidler;

    /**
     * GenerateAwb constructor.
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(Context $context, Registry $registry)
    {
        $this->registry = $registry;
        $this->urlBuidler = $context->getUrlBuilder();
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $order = $this->registry->registry('current_order');

        if (!$order || !$order->getId() || !$order->getData(OrderAttributes::IS_EMAG_ORDER)) {
            return [];
        }

        return [
            'label' => __('Generate AWB'),
            'sort_order' => 20,
            'on_click' => sprintf("location.href = '%s';", $this->urlBuidler->getUrl('emagmarketplace/awb/create', [
                'order_id' => $order->getId(),
            ])),
        ];
    }
}
