<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Form;

use Magento\Backend\Block\Template;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;

/**
 * Class Characteristic
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Form
 */
class Characteristic extends Template
{
    /**
     * @var iterable|CharacteristicInterface[]
     */
    protected $characteristics = [];

    /**
     * @var AttributeCollectionFactory
     */
    protected $attributeCollection;

    /**
     * @var array
     */
    protected $magentoAttributes = [];

    /**
     * @var array
     */
    protected $selectedAttributes = [];

    /**
     * Characteristic constructor.
     * @param Template\Context $context
     * @param AttributeCollectionFactory $attributeCollection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        AttributeCollectionFactory $attributeCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->attributeCollection = $attributeCollection->create();
    }

    /**
     * @return iterable|CharacteristicInterface[]
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @param \Traversable $characteristics
     * @return $this
     */
    public function setCharacteristics(\Traversable $characteristics)
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    /**
     * @return Attribute[]|Collection
     */
    public function getMagentoAttributes()
    {
        if (!empty($this->magentoAttributes)) {
            return $this->magentoAttributes;
        }

        $this->magentoAttributes = $this->attributeCollection->addFieldToFilter('is_user_defined', 1);

        return $this->magentoAttributes;
    }

    /**
     * @param int $characteristicId
     * @param int $attributeId
     * @return bool
     */
    public function isAttributeSelected(int $characteristicId, int $attributeId): bool
    {
        return isset($this->selectedAttributes[$characteristicId]) && $this->selectedAttributes[$characteristicId] == $attributeId;
    }

    /**
     * @param array $selectedAttributes
     * @return $this
     */
    public function setSelectedAttributes(array $selectedAttributes)
    {
        $this->selectedAttributes = $selectedAttributes;

        return $this;
    }

    /**
     * @return string
     */
    public function getValuesUrl()
    {
       return $this->getUrl('emagmarketplace/mapping/characteristicsvalues');
    }
}
