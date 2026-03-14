<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface as MagentoCategoryRepository;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\CategoryMappingRepositoryInterface;
use Zitec\EmagMarketplace\Api\CategoryRepositoryInterface as EmagCategoryRepositoryInterface;
use Zitec\EmagMarketplace\Api\CharacteristicMappingRepositoryInterface;
use Zitec\EmagMarketplace\Api\CharacteristicRepositoryInterface as EmagCharacteristicRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Exception\DuplicateMappingException;
use Zitec\EmagMarketplace\Exception\GeneralCategoryMappingSaveException;
use Zitec\EmagMarketplace\Exception\InvalidAttributeException;
use Zitec\EmagMarketplace\Exception\MissingRequiredCharacteristicsException;

/**
 * Class MappingManager
 * @package Zitec\EmagMarketplace\Model
 */
class MappingManager
{
    /**
     * @var EmagCategoryRepositoryInterface
     */
    protected $emagCategoryRepository;

    /**
     * @var EmagCharacteristicRepositoryInterface
     */
    protected $emagCharacteristicRepository;

    /**
     * @var MagentoCategoryRepository
     */
    protected $magentoCategoryRepository;

    /**
     * @var CategoryMappingRepositoryInterface
     */
    protected $categoryMappingRepository;

    /**
     * @var CharacteristicMappingRepositoryInterface
     */
    protected $characteristicMappingRepository;

    /**
     * @var Collection
     */
    protected $attributeCollection;

    /**
     * MappingManager constructor.
     * @param EmagCategoryRepositoryInterface $emagCategoryRepository
     * @param EmagCharacteristicRepositoryInterface $emagCharacteristicRepository
     * @param MagentoCategoryRepository $magentoCategoryRepository
     * @param CategoryMappingRepositoryInterface $categoryMappingRepository
     * @param CharacteristicMappingRepositoryInterface $characteristicMappingRepository
     * @param Collection $attributeCollection
     */
    public function __construct(
        EmagCategoryRepositoryInterface $emagCategoryRepository,
        EmagCharacteristicRepositoryInterface $emagCharacteristicRepository,
        MagentoCategoryRepository $magentoCategoryRepository,
        CategoryMappingRepositoryInterface $categoryMappingRepository,
        CharacteristicMappingRepositoryInterface $characteristicMappingRepository,
        Collection $attributeCollection
    ) {
        $this->emagCategoryRepository = $emagCategoryRepository;
        $this->emagCharacteristicRepository = $emagCharacteristicRepository;
        $this->magentoCategoryRepository = $magentoCategoryRepository;
        $this->categoryMappingRepository = $categoryMappingRepository;
        $this->characteristicMappingRepository = $characteristicMappingRepository;
        $this->attributeCollection = $attributeCollection;
    }

    /**
     * @param int|null $id
     * @param int $emagCategoryId
     * @param int $magentoCategoryId
     * @param array $characteristics
     * @return bool|CategoryMappingInterface
     * @throws DuplicateMappingException
     * @throws GeneralCategoryMappingSaveException
     * @throws InvalidAttributeException
     * @throws MissingRequiredCharacteristicsException
     * @throws NoSuchEntityException
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save($id = null, int $emagCategoryId, int $magentoCategoryId, array $characteristics)
    {
        $this->validateData($emagCategoryId, $magentoCategoryId, $characteristics);

        $mapping = $this->categoryMappingRepository->save($id, $emagCategoryId, $magentoCategoryId);

        if (!$mapping) {
            throw new GeneralCategoryMappingSaveException(__('An error occurred. Please check logs and try again.'));
        }

        $this->characteristicMappingRepository->deleteByCategoryMapping($mapping);

        foreach ($characteristics as $characteristicId => $attributeId) {
            $this->characteristicMappingRepository->saveWithCategoryMapping($mapping, $characteristicId, $attributeId);
        }

        return $mapping;
    }

    /**
     * @param Product $product
     * @return CategoryInterface|null
     */
    public function getProductMappedCategory(Product $product)
    {
        $categoryIds = $product->getCategoryIds();
        sort($categoryIds);

        if ($categoryIds) {
            foreach ($categoryIds as $categoryId) {
                try {
                    $categoryMapping = $this->categoryMappingRepository->getByMagentoId($categoryId);

                    return $this->emagCategoryRepository->getById($categoryMapping->getEmagCategoryId());
                } catch (\Throwable $exception) {
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * @param Product $product
     * @return null|CategoryMappingInterface
     */
    public function getCategoryMapping(Product $product)
    {
        $categoryIds = $product->getCategoryIds();
        sort($categoryIds);

        foreach ($categoryIds as $categoryId) {
            try {
                return $this->categoryMappingRepository->getByMagentoId($categoryId);
            } catch (\Throwable $exception) {
                continue;
            }
        }

        return null;
    }

    /**
     * @param int $emagCategoryId
     * @param int $magentoCategoryId
     * @param array $characteristics
     * @throws MissingRequiredCharacteristicsException
     * @throws NoSuchEntityException
     * @throws InvalidAttributeException
     */
    protected function validateData(int $emagCategoryId, int $magentoCategoryId, array $characteristics)
    {
        $emagCategory = $this->emagCategoryRepository->getById($emagCategoryId);

        // we need this so an exception gets thrown if the magento category does not exist
        $this->magentoCategoryRepository->get($magentoCategoryId);

        $emagCharacteristics = $this->emagCharacteristicRepository->getByCategory($emagCategory);

        $requiredCharacteristicIds = [];
        foreach ($emagCharacteristics as $characteristic) {
            if ($characteristic->isMandatory()) {
                $requiredCharacteristicIds[] = $characteristic->getId();
            }
        }

        if (!empty($requiredCharacteristicIds) &&
            (empty($characteristics) || !empty(array_diff($requiredCharacteristicIds, array_keys($characteristics))))
        ) {
            throw new MissingRequiredCharacteristicsException(__('Please complete all required characteristics.'));
        }

        $existingAttributes = $this->attributeCollection
            ->addFieldToFilter('main_table.attribute_id', ['in' => $characteristics]);

        if ($existingAttributes->count() !== count(array_unique($characteristics))) {
            $missingAttributes = [];

            foreach ($characteristics as $attributeId) {
                $attribute = $existingAttributes->getItemById($attributeId);

                if (!$attribute) {
                    $missingAttributes[] = $attributeId;
                }
            }

            throw new InvalidAttributeException(__('Invalid attribute ids: "%1".', $missingAttributes));
        }
    }
}
