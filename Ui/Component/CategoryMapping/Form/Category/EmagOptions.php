<?php

namespace Zitec\EmagMarketplace\Ui\Component\CategoryMapping\Form\Category;

use Magento\Framework\Data\OptionSourceInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

/**
 * Class EmagOptions
 * @package Zitec\EmagMarketplace\Ui\Component\CategoryMapping\Form\Category
 */
class EmagOptions implements OptionSourceInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var array
     */
    protected $categoriesTree;

    /**
     * Options constructor.
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(CategoryCollectionFactory $categoryCollectionFactory)
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return $this->getCategoriesTree();
    }

    /**
     * @return array
     */
    protected function getCategoriesTree(): array
    {
        if ($this->categoriesTree === null) {
            /* @var $collection Collection */
            $collection = $this->categoryCollectionFactory->create()
                ->setOrder('name', 'ASC');

            $categoryById = [
                0 => [
                    'value' => 0
                ],
            ];

            foreach ($collection as $category) {
                if (!isset($categoryById[$category->getId()])) {
                    $categoryById[$category->getId()] = ['value' => $category->getId()];
                }

                $categoryById[$category->getId()]['is_active'] = 1;
                $categoryById[$category->getId()]['label'] = $category->getName();
                $categoryById[0]['optgroup'][] = &$categoryById[$category->getId()];
            }

            $this->categoriesTree = $categoryById[0]['optgroup'];
        }

        return $this->categoriesTree;
    }

}
