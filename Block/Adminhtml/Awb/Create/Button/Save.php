<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Awb\Create\Button;

use Zitec\EmagMarketplace\Block\Adminhtml\Button\AbstractButton;

/**
 * Class Save
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Awb\Create\Button
 */
class Save extends AbstractButton
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Generate AWB'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
