<?php

namespace Zitec\EmagMarketplace\Plugin;

use Zitec\EmagMarketplace\Block\Adminhtml\Order\View\Button\GenerateAwb;

/**
 * Class AddAwbGenerateButton
 * @package Zitec\EmagMarketplace\Plugin
 */
class AddAwbGenerateButton
{
    /**
     * @var GenerateAwb
     */
    protected $generateAwb;

    /**
     * AddAwbGenerateButton constructor.
     * @param GenerateAwb $generateAwb
     */
    public function __construct(GenerateAwb $generateAwb)
    {
        $this->generateAwb = $generateAwb;
    }

    /**
     * @param \Magento\Sales\Block\Adminhtml\Order\View $view
     */
    public function beforeSetLayout(\Magento\Sales\Block\Adminhtml\Order\View $view)
    {
        $view->addButton(
            'generate_awb_button',
            $this->generateAwb->getButtonData()
        );
    }
}