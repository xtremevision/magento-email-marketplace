<?php

namespace Zitec\EmagMarketplace\Model\CategoryMapping;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\CollectionFactory;

/**
 * Class DataProvider
 * @package Zitec\EmagMarketplace\Model\CategoryMapping
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }
}
