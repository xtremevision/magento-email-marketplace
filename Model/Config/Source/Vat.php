<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Escaper;
use Magento\Framework\Option\ArrayInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Vat\CollectionFactory;

/**
 * Class Vat
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class Vat implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $vatCollection;
    
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * Vat constructor.
     *
     * @param CollectionFactory $vatCollection
     * @param Escaper $escaper
     */
    public function __construct(
        CollectionFactory $vatCollection,
        Escaper $escaper
    ) {

        $this->vatCollection = $vatCollection;
        $this->escaper       = $escaper;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->vatCollection->create();

        $optionArray = [];
        
        if(!$collection){
            return $optionArray; 
        }

        foreach ($collection as $option) {
            $optionArray[$option->getEmagId()] = $this->escaper->escapeHtml($option->getVatRate());
        }

        return $optionArray;
    }
}
