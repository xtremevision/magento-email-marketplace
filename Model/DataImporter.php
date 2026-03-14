<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Api\CategoryRepositoryInterface;
use Zitec\EmagMarketplace\Api\CharacteristicRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\ApiWrapper\Exceptions\FailedRequestException;
use Zitec\EmagMarketplace\ApiWrapper\Exceptions\MissingEndpointException;
use Zitec\EmagMarketplace\ApiWrapper\Requests\Category\ReadRequest;
use Zitec\EmagMarketplace\Exception\ApiResponseErrorException;
use Zitec\EmagMarketplace\Model\ResourceModel\Category as CategoryResource;
use Zitec\EmagMarketplace\Model\ResourceModel\Category\Collection as CategoryCollection;
use Zitec\EmagMarketplace\Model\ResourceModel\CategoryMapping\CollectionFactory as CategoryMappingCollection;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic as CharacteristicResource;
use Zitec\EmagMarketplace\Model\ResourceModel\Characteristic\Collection as CharacteristicCollection;
use Zitec\EmagMarketplace\Model\ResourceModel\CharacteristicMapping\CollectionFactory as CharacteristicMappingCollection;

/**
 * Class DataImporter
 * @package Zitec\EmagMarketplace\Model
 */
class DataImporter
{
    const CATEGORIES_ITEMS_PER_PAGE = 50;

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var CategoryCollection
     */
    protected $categoryCollection;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $emagCategories;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var CharacteristicCollection
     */
    protected $characteristicCollection;

    /**
     * @var CharacteristicFactory
     */
    protected $characteristicFactory;

    /**
     * @var CharacteristicRepositoryInterface
     */
    protected $characteristicRepository;

    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @var CharacteristicResource
     */
    protected $characteristicResource;

    /**
     * @var CategoryMappingCollection
     */
    protected $categoryMappingCollection;

    /**
     * @var CharacteristicMappingCollection
     */
    protected $characteristicMappingCollection;

    /**
     * @var ResourceConnection
     */
    protected $connection;

    /**
     * DataImporter constructor.
     * @param ApiClient $apiClient
     * @param LoggerInterface $logger
     * @param CategoryCollection $categoryCollection
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CharacteristicCollection $characteristicCollection
     * @param CharacteristicFactory $characteristicFactory
     * @param CharacteristicRepositoryInterface $characteristicRepository
     * @param CategoryResource $categoryResource
     * @param CharacteristicResource $characteristicResource
     * @param CategoryMappingCollection $categoryMappingCollection
     * @param CharacteristicMappingCollection $characteristicMappingCollection
     * @param ResourceConnection $connection
     */
    public function __construct(
        ApiClient $apiClient,
        LoggerInterface $logger,
        CategoryCollection $categoryCollection,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository,
        CharacteristicCollection $characteristicCollection,
        CharacteristicFactory $characteristicFactory,
        CharacteristicRepositoryInterface $characteristicRepository,
        CategoryResource $categoryResource,
        CharacteristicResource $characteristicResource,
        CategoryMappingCollection $categoryMappingCollection,
        CharacteristicMappingCollection $characteristicMappingCollection,
        ResourceConnection $connection
    ) {
        $this->apiClient = $apiClient;
        $this->categoryCollection = $categoryCollection;
        $this->categoryFactory = $categoryFactory;
        $this->logger = $logger;
        $this->categoryRepository = $categoryRepository;
        $this->characteristicCollection = $characteristicCollection;
        $this->characteristicFactory = $characteristicFactory;
        $this->characteristicRepository = $characteristicRepository;
        $this->categoryResource = $categoryResource;
        $this->characteristicResource = $characteristicResource;
        $this->categoryMappingCollection = $categoryMappingCollection;
        $this->characteristicMappingCollection = $characteristicMappingCollection;
        $this->connection = $connection;
    }

    /**
     * @return bool
     */
    public function import(): bool
    {
        try {
            $this->fetchData();

            $this->updateData();
            
            return true;
        } catch (\Throwable $exception) {
            $this->logger->critical($exception);
            return false;
        }
    }

    /**
     * @throws FailedRequestException
     * @throws MissingEndpointException
     * @throws ApiResponseErrorException
     */
    protected function fetchData()
    {
        $page = 1;
        $request = new ReadRequest();
        $this->apiClient->setArrayResponse(true);

        do {
            $request->setRequestData([
                'currentPage' => $page,
                'is_allowed' => 1,
                'itemsPerPage' => self::CATEGORIES_ITEMS_PER_PAGE,
            ]);

            $timeStart = microtime(true);

            $response = $this->apiClient->sendRequest($request);

            if (!isset($response['isError'], $response['results']) || $response['isError']) {
                if (!isset($response['results'])) {
                    throw new ApiResponseErrorException(__('Error occured during eMAG data import.') . __FUNCTION__);
                } else {
                    throw new ApiResponseErrorException(implode(', ', $response['messages']));
                }
            }

            foreach ($response['results'] ?? [] as $result) {
                unset($result['parent_id']);
                $this->emagCategories[] = $result;
            }

            $page++;

            $timeEnd = microtime(true);
            $time = $timeEnd - $timeStart;
            $sleepTime = 3 - $time;

            if ($sleepTime > 0) {
                sleep($sleepTime);
            }
        } while (count($response['results']));

        unset($results);
    }

    /**
     * @throws \Exception
     */
    protected function updateData()
    {
        $categoryMappings = $this->categoryMappingCollection->create();
        $mappedCategoryIds = $categoryMappings->getColumnValues('emag_category_id');
        $existingCategories = $this->categoryCollection->addFieldToFilter('id', ['in' => $mappedCategoryIds]);

        $characteristicMappings = $this->characteristicMappingCollection->create();
        $mappedCharacteristicIds = $characteristicMappings->getColumnValues('emag_characteristic_id');
        $existingCharacteristics = $this->characteristicCollection->addFieldToFilter('id',
            ['in' => $mappedCharacteristicIds]);

        $existingCharacteristicEmagIds = [];
        if ($existingCharacteristics) {
            $existingCharacteristicEmagIds = array_unique($existingCharacteristics->getColumnValues('emag_id'));
        }

        $categoriesData = [];
        $characteristicsData = [];

        foreach ($this->emagCategories as $category) {
            $existingCategory = $existingCategories->getItemByColumnValue('emag_id', $category['id']);

            if (!$existingCategory || !$existingCategory->getId()) {
                $categoriesData[] = [
                    'emag_id' => $category['id'],
                    'name' => $category['name'],
                    'is_ean_mandatory' => $category['is_ean_mandatory'],
                ];

                if (array_key_exists('characteristics', $category) && is_array($category['characteristics'])) {
                    foreach ($category['characteristics'] as $characteristic) {
                        $characteristicsData[] = [
                            'emag_id' => $characteristic['id'],
                            'name' => $characteristic['name'],
                            'is_mandatory' => $characteristic['is_mandatory'],
                            'allow_new_value' => $characteristic['allow_new_value'],
                            'category_emag_id' => $category['id'],
                        ];
                    }
                }
            } else {
                $existingCategory->setData('name', $category['name']);
                $existingCategory->setData('is_ean_mandatory', $category['is_ean_mandatory']);

                if (array_key_exists('characteristics', $category) && is_array($category['characteristics'])) {
                    foreach ($category['characteristics'] as $characteristic) {
                        if (!in_array($characteristic['id'], $existingCharacteristicEmagIds)) {
                            $characteristicsData[] = [
                                'emag_id' => $characteristic['id'],
                                'name' => $characteristic['name'],
                                'is_mandatory' => $characteristic['is_mandatory'],
                                'allow_new_value' => $characteristic['allow_new_value'],
                                'category_emag_id' => $category['id'],
                            ];
                        } else {
                            $existingCharacteristicsByEmagId = $existingCharacteristics->getItemsByColumnValue('emag_id',
                                $characteristic['id']);
                            foreach ($existingCharacteristicsByEmagId as $characteriscByEmagId) {
                                if ($characteriscByEmagId->getCategoryEmagId() == $category['id']) {
                                    $characteriscByEmagId->setData('name', $characteristic['name']);
                                    $characteriscByEmagId->setData('is_mandatory', $characteristic['is_mandatory']);
                                    $characteriscByEmagId->setData('allow_new_value',
                                        $characteristic['allow_new_value']);

                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        $existingCategories->save();
        $existingCharacteristics->save();
        $connection = $this->connection->getConnection('core_write');

        try {
            $connection->beginTransaction();

            $this->characteristicResource->emptyTable($mappedCharacteristicIds);
            $this->categoryResource->emptyTable($mappedCategoryIds);

            $this->categoryResource->massInsert($categoriesData);
            $this->characteristicResource->massInsert($characteristicsData);

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();

            throw $e;
        }
    }

    /**
     * @param int $id
     */
    public function importCharactersticsByCategoryId(int $id)
    {
        $data = $this->fetchSingleCategoryData($id);

        $this->updateCharacteristicsMandatoryValues(reset($data['results']));
    }

    /**
     * @param int $id
     * @return array|object
     * @throws ApiResponseErrorException
     */
    protected function fetchSingleCategoryData(int $id)
    {
        $request = new ReadRequest();
        $this->apiClient->setArrayResponse(true);

        $request->setRequestData([
            'id' => $id,
        ]);

        $response = $this->apiClient->sendRequest($request);

        if (!isset($response['isError'], $response['results']) || $response['isError']) {
            if (!isset($response['results'])) {
                throw new ApiResponseErrorException(__('Error occured during eMAG data import.') . __FUNCTION__);
            } else {
                throw new ApiResponseErrorException(implode(', ', $response['messages']));
            }
        }

        return $response;
    }

    /**
     * @param array $data
     * @throws ApiResponseErrorException
     */
    protected function updateCharacteristicsMandatoryValues(array $data)
    {
        $characteristicColection = $this->characteristicCollection->addFieldToFilter(CharacteristicInterface::CATEGORY_EMAG_ID,
            $data['id']);

        if (!isset($data['characteristics'])) {
            throw new ApiResponseErrorException(__('Characteristics missing.'));
        }

        foreach ($data['characteristics'] as $characteristicData) {
            $characteristic = $characteristicColection->getItemByColumnValue('emag_id', $characteristicData['id']);

            if ($characteristic && $characteristic->getId() && isset($characteristicData['values'])) {
                $characteristic->setValues(json_encode($characteristicData['values']));
                $characteristic->setAllowNewValue($characteristicData['allow_new_value'] == 1 ? true : false);
            }
        }

        $characteristicColection->save();
    }
}
