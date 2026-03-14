<?php

namespace Zitec\EmagMarketplace\Ui\Component\Awb\Grid\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Zitec\EmagMarketplace\Model\Awb;

/**
 * Class Download
 * @package Zitec\EmagMarketplace\Ui\Component\Awb\Grid\Column
 */
class Download extends Column
{
    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
     * Download constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        $sizes = Awb::$sizes;
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    foreach ($sizes as $size) {
                        $item[$name]['download_' . $size] = [
                            'href' => $this->_urlBuilder->getUrl('emagmarketplace/awb/download', [
                                'id' => $item['id'],
                                'format' => $size,
                            ]),
                            'label' => __('Download %1', $size),
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
