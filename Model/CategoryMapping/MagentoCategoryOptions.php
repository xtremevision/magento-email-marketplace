<?php

namespace Zitec\EmagMarketplace\Model\CategoryMapping;

use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class MagentoCategoryOptions
 * @package Zitec\EmagMarketplace\Model\CategoryMapping
 */
class MagentoCategoryOptions implements OptionSourceInterface
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * MagentoCategoryOptions constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    public function toOptionArray($valueField = 'id', $labelField = 'name', array $additional = []): array
    {
        $response = [];
        $additional['value'] = $valueField;
        $additional['label'] = $labelField;

        foreach ($this->collection->setOrder('name', 'ASC')->getItems() as $item) {
            $data = [];
            foreach ($additional as $code => $field) {
                $data[$code] = $item->getData($field);
            }

            if (!empty($data)) {
                $response[] = $data;
            }
        }

        return $response;
    }
}
