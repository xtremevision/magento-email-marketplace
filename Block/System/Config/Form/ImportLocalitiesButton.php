<?php

namespace Zitec\EmagMarketplace\Block\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\AbstractElement as FormAbstractElement;

/**
 * Class ImportLocalitiesButton
 * @package Zitec\EmagMarketplace\Block\System\Config\Form
 */
class ImportLocalitiesButton extends Field
{
    const BUTTON_TEMPLATE = 'system/config/form/import_localities_button.phtml';

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        if (!$this->getTemplate()) {
            $this->setTemplate(static::BUTTON_TEMPLATE);
        }

        return $this;
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * @return string
     */
    public function getAjaxImportLocalitiesUrl()
    {
        return $this->getUrl('emagmarketplace/localities/import');
    }

    /**
     * @param FormAbstractElement $element
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * 
     * @return string
     */
    protected function _getElementHtml(FormAbstractElement $element)
    {
        $this->addData(
            [
                'id'           => 'import_localities_button',
                'button_label' => _('Import Localities'),
            ]
        );

        return $this->_toHtml();
    }
}
