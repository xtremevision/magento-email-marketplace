<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer\CountRequest;
use Zitec\EmagMarketplace\ApiWrapper\Requests\ProductOffer\ReadRequest;
use Zitec\EmagMarketplace\Exception\ApiResponseErrorException;

/**
 * Class ProductStatus
 * @package Zitec\EmagMarketplace\Model
 */
class ProductStatus
{
    const PRODUCT_OFFER_READ_PER_PAGE = 100;

    /**
     * @var
     */
    protected $products;

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * ProductStatus constructor.
     * @param ApiClient $apiClient
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     * @param Registry $registry
     */
    public function __construct(
        ApiClient $apiClient,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        Registry $registry
    ) {
        $this->logger = $logger;
        $this->apiClient = $apiClient;
        $this->collectionFactory = $collectionFactory;
        $this->registry = $registry;
    }

    /**
     *
     */
    public function importProductStatus()
    {
        $this->registry->register('IMPORTING_STATUS',1);
        
        // Read offers
        $this->fetchData();

        // Save imported data
        $this->saveData();
    }

    /**
     *
     */
    public function saveData()
    {
        if (!$this->products) {
            return;
        }

        $productIds = array_column($this->products, 'id');
        $this->products = array_column($this->products, null, 'id');

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['in' => [$productIds]]);
        $collection->addFieldToFilter('emkp_sent_to_emkp', ['eq' => 1]);
        $collection->addFieldToFilter('emkp_visible', ['eq' => 1]);

        if (!$collection->getSize()) {
            return;
        }

        foreach ($collection as $prod) {
            $prod->setData(
                ProductAttributes::STATUS,
                $this->products[$prod->getId()]['status'] ? 'active' : 'inactive'
            );

            $validationStatus = reset($this->products[$prod->getId()]['validation_status']);
            $validationStatusMessage = $validationStatus['description'];
            if ($validationStatus['errors']) {
                $validationStatusMessage .= PHP_EOL . __(' Errors: ');
                if (is_array($validationStatus['errors'])) {
                    foreach ($validationStatus['errors'] as $status) {
                        if (array_key_exists('message', $status)) {
                            $validationStatusMessage .= PHP_EOL . __('Message: %1', $status['message']);
                        }
                        
                        if (array_key_exists('user_message', $status)) {
                            foreach ($status['user_message'] as $userMessage) {
                                if (array_key_exists('error_description', $userMessage)) {
                                    $validationStatusMessage .= PHP_EOL . __('Error Description: %1',
                                            $userMessage['error_description']);
                                }

                                if (array_key_exists('user_message', $userMessage) && $userMessage['user_message']) {
                                    $validationStatusMessage .= PHP_EOL . __('User Message: %1',
                                            $userMessage['user_message']);
                                }

                                if (array_key_exists('reasons', $userMessage) && is_array($userMessage['reasons'])) {
                                    $validationStatusMessage .= PHP_EOL . __('Reasons: ');
                                    foreach ($userMessage['reasons'] as $reason) {
                                        if (!empty($reason['seller_text'])) {
                                            $validationStatusMessage .= PHP_EOL . ' - ' . $reason['seller_text'];
                                        }
                                        if (!empty($reason['user_message'])) {
                                            $validationStatusMessage .= PHP_EOL . ' - ' . $reason['user_message'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $validationStatusMessage .= 'Errors: ' . print_r($validationStatus['errors'], true);
                }
            }

            $prod->setData(
                ProductAttributes::VALIDATION_STATUS,
                $validationStatusMessage
            );

            $offerValidationStatus = $this->products[$prod->getId()]['offer_validation_status'];

            $offerValidationStatusMessage = $offerValidationStatus['description'];
            if ($offerValidationStatus['errors']) {
                $offerValidationStatusMessage .= print_r($offerValidationStatus['errors'], true);
            }
            $prod->setData(
                ProductAttributes::OFFER_VALIDATION_STATUS,
                $offerValidationStatusMessage
            );
        }

        $collection->save();
    }

    /**
     * @return array
     * @throws ApiResponseErrorException
     */
    public function countData(): array
    {
        $request = new CountRequest([
            'itemsPerPage' => self::PRODUCT_OFFER_READ_PER_PAGE,
        ]);
        $this->apiClient->setArrayResponse(true);

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
     *
     */
    public function fetchData()
    {
        $result = $this->countData();

        $requestsList = [];
        $noOfPages = $result['results']['noOfPages'];

        for ($i = 1; $i <= $noOfPages; $i++) {
            $requestsList[] = new ReadRequest([
                'currentPage' => $i,
                'itemsPerPage' => $result['results']['itemsPerPage'],
            ]);
        }

        $this->apiClient->setArrayResponse(true);

        $results = $this->apiClient->sendMultiRequest($requestsList);

        $products = array_column($results, 'results');

        $products = array_merge(... $products);

        unset($results);

        $this->products = $products;
    }
}