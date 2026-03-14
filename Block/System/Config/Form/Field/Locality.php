<?php

namespace Zitec\EmagMarketplace\Block\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Locality
 * @package Zitec\EmagMarketplace\Block\System\Config\Form\Field
 */
class Locality extends Field
{
    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->addData(['data-action' => $this->getAjaxSearchLocalitiesUrl()]);

        return $element->getElementHtml();
    }

    /**
     * @return string
     */
    public function getAjaxSearchLocalitiesUrl()
    {
        return $this->getUrl('emagmarketplace/localities/search');
    }
}