<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class AwbBack
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Button
 */
class AwbBack extends AbstractButton
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * AwbBack constructor.
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        Context $context
    ) {
        parent::__construct($context);
        $this->registry = $registry;
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $order = $this->registry->registry('current_order');
        $params = [];
        if ($order->getId()) {
            $params['order_id'] = $order->getId();
        }

        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';",
                $this->getUrl('sales/order/view', $params)),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
}
