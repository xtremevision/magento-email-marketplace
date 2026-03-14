<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Button;

use Zitec\EmagMarketplace\Block\Adminhtml\Button\AbstractButton;

/**
 * Class Save
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Button
 */
class Save extends AbstractButton
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'primary js-emkp-save-mapping',
            'on_click' => '',
            'sort_order' => 90,
        ];
    }
}
