<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Grid\Renderer\Awb;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\Action as RendererAction;
use Magento\Framework\DataObject;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;
use Zitec\EmagMarketplace\Model\Awb;

/**
 * Class Action
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Grid\Renderer\Awb
 */
class Action extends RendererAction
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Action constructor.
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $jsonEncoder, $data);
        $this->registry = $registry;
    }

    /**
     * @param DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $order = $this->registry->registry('current_order');

        if ($order->getId()) {

            $sizes = Awb::$sizes;
            $actions = [];

            foreach ($sizes as $size) {
                $actions[] = [
                    'url' => $this->getUrl('emagmarketplace/awb/download',
                        ['id' => $row->getId(), 'format' => 'A5']),
                    'caption' => __('Download %1', $size),
                ];
            }
            $this->getColumn()->setActions(
                $actions
            );
        }

        return parent::render($row);
    }
}
