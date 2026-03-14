<?php

namespace Zitec\EmagMarketplace\Ui\Component\CategoryMapping\Grid\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Action
 * @package Zitec\EmagMarketplace\Ui\Component\Listing\Grid\Column
 */
class Action extends Column
{
    const EDIT_URL = 'emagmarketplace/mapping/edit';
    const DELETE_URL = 'emagmarketplace/mapping/delete';

    /** @var UrlInterface */
    protected $_urlBuilder;

    /**
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
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(self::EDIT_URL, ['id' => $item['id']]),
                        'label' => __('Edit'),
                    ];

                    $item[$name]['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(self::DELETE_URL, ['id' => $item['id']]),
                        'label' => __('Delete'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}
