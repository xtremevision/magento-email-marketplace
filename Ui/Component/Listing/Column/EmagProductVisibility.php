<?php

namespace Zitec\EmagMarketplace\Ui\Component\Listing\Column;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class EmagProductVisibility
 * @package Zitec\EmagMarketplace\Ui\Component\Listing\Column
 */
class EmagProductVisibility extends Column
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * EmagProductVisibility constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ProductFactory $productFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductFactory $productFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->productFactory = $productFactory;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $product = $this->productFactory->create()->load($item['entity_id']);
                $visible = $product->getData('emkp_visible');

                switch ($visible) {
                    case '0':
                        $label = __('No');
                        break;
                    case '1':
                        $label = __('Yes');
                        break;
                    default:
                        $label = __('No');
                        break;

                }
                $item[$this->getData('name')] = $label;
            }
        }

        return $dataSource;
    }
}