<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit;

use Magento\Backend\Block\Template;

/**
 * Class FormWrapper
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit
 */
class FormWrapper extends Template
{
    /**
     * @return string
     */
    public function getCharacteristicsUrl(): string
    {
        return $this->getUrl('*/*/characteristicsform');
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('*/*/save');
    }
}
