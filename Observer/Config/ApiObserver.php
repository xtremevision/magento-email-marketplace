<?php

namespace Zitec\EmagMarketplace\Observer\Config;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface as Logger;
use Zitec\EmagMarketplace\Api\CourierRepositoryInterface;
use Zitec\EmagMarketplace\Api\HandlingTimeRepositoryInterface;
use Zitec\EmagMarketplace\Api\VatRepositoryInterface;
use Zitec\EmagMarketplace\ApiWrapper\Requests\CourierAccount\ReadRequest as CourierAccountReadRequest;
use Zitec\EmagMarketplace\ApiWrapper\Requests\HandlingTime\ReadRequest as HandlingTimeReadRequest;
use Zitec\EmagMarketplace\ApiWrapper\Requests\Vat\ReadRequest as VatReadRequest;
use Zitec\EmagMarketplace\Model\ApiClient;

/**
 * Class ApiObserver
 * @package Zitec\EmagMarketplace\Observer\Config
 */
class ApiObserver implements ObserverInterface
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var ReadRequest
     */
    protected $vatReadRequest;

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var ReadRequest
     */
    protected $handlingTimeReadRequest;

    /**
     * @var ReadRequest
     */
    protected $courierReadRequest;

    /**
     * @var VatRepositoryInterface
     */
    protected $vatRepository;

    /**
     * @var HandlingTimeRepositoryInterface
     */
    protected $handlingTimeRepository;

    /**
     * @var CourierRepositoryInterface
     */
    protected $courierRepository;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * ApiObserver constructor.
     *
     * @param Logger $logger
     * @param ApiClient $apiClient
     * @param VatReadRequest $vatReadRequest
     * @param VatRepositoryInterface $vatRepository
     * @param HandlingTimeReadRequest $handlingTimeReadRequest
     * @param HandlingTimeRepositoryInterface $handlingTimeRepository
     * @param CourierAccountReadRequest $courierReadRequest
     * @param CourierRepositoryInterface $courierRepository
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Logger $logger,
        ApiClient $apiClient,
        VatReadRequest $vatReadRequest,
        VatRepositoryInterface $vatRepository,
        HandlingTimeReadRequest $handlingTimeReadRequest,
        HandlingTimeRepositoryInterface $handlingTimeRepository,
        CourierAccountReadRequest $courierReadRequest,
        CourierRepositoryInterface $courierRepository,
        ManagerInterface $messageManager
    ) {
        $this->logger = $logger;
        $this->vatReadRequest = $vatReadRequest;
        $this->apiClient = $apiClient;
        $this->handlingTimeReadRequest = $handlingTimeReadRequest;
        $this->courierReadRequest = $courierReadRequest;
        $this->vatRepository = $vatRepository;
        $this->handlingTimeRepository = $handlingTimeRepository;
        $this->courierRepository = $courierRepository;
        $this->messageManager = $messageManager;
    }

    /**
     * @param EventObserver $observer
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return bool
     */
    public function execute(EventObserver $observer): bool
    {
        try {
            $errors = $this->importData();

            if ($errors) {
                foreach ($errors as $error) {
                    $this->messageManager->addErrorMessage(__($error));
                }

                return false;
            }

            $this->messageManager->addSuccessMessage(__('Successful connection to eMAG Marketplace API.'));

            return true;
        } catch (\Throwable $exception) {
            $this->logger->critical($exception);

            return false;
        }
    }

    /**
     * @return array
     */
    protected function importData(): array
    {
        $responseRepositories = [
            $this->vatRepository,
            $this->handlingTimeRepository,
            $this->courierRepository,
        ];

        $requests = [
            $this->vatReadRequest,
            $this->handlingTimeReadRequest,
            $this->courierReadRequest,
        ];

        $this->apiClient->setArrayResponse(true);
        $responses = $this->apiClient->sendMultiRequest($requests);

        $errorMessages = [];

        foreach ($responses as $key => $response) {
            if (!empty($response)) {
                if (!array_key_exists('isError', $response) || $response['isError'] ||
                    !array_key_exists('results', $response)
                ) {
                    if (array_key_exists('messages', $response) && !empty($response['messages'])) {
                        $errorMessages[] = implode(PHP_EOL, $response['messages']);
                    } else {
                        $errorMessages[] = __('There was a problem connecting to the eMag Marketplace API. Empty Response.');
                    }
                } else {
                    if (!$response['results']) {
                        switch ($key) {
                            case 0:
                                $errorMessages[] = __('Could not download VAT values.');
                                break;
                            case 1:
                                $errorMessages[] = __('Could not download Handling times.');
                                break;
                            case 2:
                                $errorMessages[] = __('Could not download Courier Accounts.If you do not plan on generating AWBs through the eMag API, you can ignore this message.');
                                break;
                        }
                        $errorMessages[] = __('Please make sure you have the missing data set in your eMag Marketplace Seller Account.');
                        $errorMessages[] = __('After setting the missing data in your eMag account, click the "Save" button on this page again to import the data.');
                    } else {
                        $responseRepositories[$key]->updateData($response['results']);
                    }
                }
            } else {
                $errorMessages[] = __('Error connecting to eMAG Marketplace API. Response is empty. ');
            }
        }

        return $errorMessages;
    }
}
