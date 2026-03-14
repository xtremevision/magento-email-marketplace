<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Button;

/**
 * Class Back
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Button
 */
class Back extends AbstractButton
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getUrl('*/*/')),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
}
