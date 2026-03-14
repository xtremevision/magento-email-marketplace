<?php

namespace Zitec\EmagMarketplace\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Table as MagentoTable;
use Magento\Framework\Escaper;

/**
 * Class AlertManager
 * @package Zitec\EmagMarketplace\Model
 */
class Table extends MagentoTable
{
    /**
     * @var Escaper
     */
    protected $escaperProtected;

    /**
     * Table constructor.
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param Escaper $escaperProtected
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        Escaper $escaperProtected
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
        $this->escaperProtected = $escaperProtected;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return array|string|bool
     */
    public function getOptionText($value)
    {
        $isMultiple = false;
        if (!is_array($value) && strpos($value, ',') === true) {
            $isMultiple = true;
            $value = explode(',', $value);
        }

        $options = $this->getSpecificOptions($value, false);

        if (!is_array($value)) {
            $value = [$value];
        }
        $optionsText = [];
        foreach ($options as $item) {
            if (in_array($item['value'], $value)) {
                $optionsText[] = $this->escaperProtected->escapeHtml($item['label']);
            }
        }

        if ($isMultiple) {
            return $optionsText;
        } elseif ($optionsText) {
            return $optionsText[0];
        }

        return false;
    }
}