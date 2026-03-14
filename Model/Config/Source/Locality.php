<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Escaper;
use Magento\Framework\Option\ArrayInterface;
use Zitec\EmagMarketplace\Api\Data\LocalityInterface;
use Zitec\EmagMarketplace\Model\Config;
use Zitec\EmagMarketplace\Model\ResourceModel\Locality\CollectionFactory;

/**
 * Class Locality
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class Locality implements ArrayInterface
{
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var CollectionFactory
     */
    protected $localityCollection;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Locality constructor.
     *
     * @param CollectionFactory $localityCollection
     * @param Escaper $escaper
     * @param Config $config
     */
    public function __construct(
        CollectionFactory $localityCollection,
        Escaper $escaper,
        Config $config
    ) {
        $this->escaper = $escaper;
        $this->localityCollection = $localityCollection;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->localityCollection->create()->setPageSize(100)->setCurPage(1);

        $optionArray = [];

        if ($selectedId = $this->config->getShippingLocality()) {
            $selected = $this->localityCollection->create()->addFieldToFilter(LocalityInterface::EMAG_ID,
                ['eq' => $selectedId]);

            if ($selected) {
                $selectedLocality = $selected->getFirstItem();

                if ($selectedLocality->getId()) {
                    $optionArray[$selectedLocality->getEmagId()] = $this->escaper->escapeHtml($selectedLocality->getName()) .
                        ' (' . $this->escaper->escapeHtml($selectedLocality->getRegion3()) . ', ' . $this->escaper->escapeHtml($selectedLocality->getRegion()) . ')';
                }

            }
        }

        foreach ($collection as $option) {
            if ($option->getId()) {
                $optionArray[$option->getEmagId()] = $this->escaper->escapeHtml($option->getName()) .
                    ' (' . $this->escaper->escapeHtml($option->getRegion3()) . ', ' . $this->escaper->escapeHtml($option->getRegion()) . ')';
            }
        }

        return $optionArray;
    }
}
