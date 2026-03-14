<?php

namespace Zitec\EmagMarketplace\Block\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Disabled
 * @package Zitec\EmagMarketplace\Block\System\Config\Form\Field
 */
class Disabled extends Field
{
    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->addData(['disabled' => true,]);

        return $element->getElementHtml();
    }
}
