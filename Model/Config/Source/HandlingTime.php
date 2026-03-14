<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Escaper;
use Magento\Framework\Option\ArrayInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime\CollectionFactory;

/**
 * Class HandlingTime
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class HandlingTime implements ArrayInterface
{
    /**
     * @var Escaper
     */
    protected $escaper;
    
    /**
     * @var CollectionFactory
     */
    protected $handlingCollection;

    /**
     * HandlingTime constructor.
     *
     * @param CollectionFactory $handlingCollection
     * @param Escaper $escaper
     */
    public function __construct(
        CollectionFactory $handlingCollection,
        Escaper $escaper
    ) {
        $this->escaper            = $escaper;
        $this->handlingCollection = $handlingCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->handlingCollection->create();

        $optionArray = [];

        foreach ($collection as $option) {
            $optionArray[$option->getHandlingTime()] = $this->escaper->escapeHtml($option->getHandlingTime());
        }

        return $optionArray;
    }
}
