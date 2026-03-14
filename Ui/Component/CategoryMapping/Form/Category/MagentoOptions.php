<?php

namespace Zitec\EmagMarketplace\Ui\Component\CategoryMapping\Form\Category;

use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\CollectionFactory;

/**
 * Class MagentoOptions
 * @package Zitec\EmagMarketplace\Ui\Component\CategoryMapping\Form\Category
 */
class MagentoOptions implements OptionSourceInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $categoriesTree;

    /**
     * @var CollectionFactory
     */
    protected $categoryMappingCollectionFactory;

    /**
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param RequestInterface $request
     * @param CollectionFactory $categoryMappingCollectionFactory
     */
    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory,
        RequestInterface $request,
        CollectionFactory $categoryMappingCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->request = $request;
        $this->categoryMappingCollectionFactory = $categoryMappingCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return $this->getCategoriesTree();
    }

    /**
     * Retrieve categories tree
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getCategoriesTree(): array
    {
        if ($this->categoriesTree === null) {
            /** @var Collection $categoryMappingCollection */
            $categoryMappingCollection = $this->categoryMappingCollectionFactory->create();

            $usedCategories = $categoryMappingCollection->getColumnValues('magento_category_id');
            $usedCategories[] = CategoryModel::TREE_ROOT_ID;
            $usedCategories = array_unique($usedCategories);

            $storeId = $this->request->getParam('store');
            /* @var $matchingNamesCollection \Magento\Catalog\Model\ResourceModel\Category\Collection */
            $matchingNamesCollection = $this->categoryCollectionFactory->create();

            $matchingNamesCollection->addAttributeToSelect('path')
                ->addAttributeToFilter('entity_id', ['nin' => $usedCategories])
                ->setStoreId($storeId);

            $shownCategoriesIds = [];

            /** @var \Magento\Catalog\Model\Category $category */
            foreach ($matchingNamesCollection as $category) {
                foreach (explode('/', $category->getPath()) as $parentId) {
                    $shownCategoriesIds[$parentId] = 1;
                }
            }

            /* @var $collection \Magento\Catalog\Model\ResourceModel\Category\Collection */
            $collection = $this->categoryCollectionFactory->create();

            $collection->addAttributeToFilter('entity_id', ['in' => array_keys($shownCategoriesIds)])
                ->addAttributeToSelect(['name', 'is_active', 'parent_id'])
                ->addAttributeToFilter('entity_id', ['nin' => $usedCategories])
                ->setStoreId($storeId);

            $categoryById = [
                CategoryModel::TREE_ROOT_ID => [
                    'value' => CategoryModel::TREE_ROOT_ID
                ],
            ];

            foreach ($collection as $category) {
                foreach ([$category->getId(), $category->getParentId()] as $categoryId) {
                    if (!isset($categoryById[$categoryId])) {
                        $categoryById[$categoryId] = ['value' => $categoryId];
                    }
                }

                $categoryById[$category->getId()]['is_active'] = $category->getIsActive();
                $categoryById[$category->getId()]['label'] = $category->getName();
                $categoryById[$category->getParentId()]['optgroup'][] = &$categoryById[$category->getId()];
            }

            $this->categoriesTree = $categoryById[CategoryModel::TREE_ROOT_ID]['optgroup'];
        }

        return $this->categoriesTree;
    }
}
