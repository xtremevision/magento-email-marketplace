<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Module\ModuleList;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface as MagentoLogger;
use Zitec\EmagMarketplace\ApiWrapper\AlertManager\AlertManagerInterface;
use Zitec\EmagMarketplace\ApiWrapper\InstantiableClient;
use Zitec\EmagMarketplace\ApiWrapper\Logger\LoggerInterface;
use Zitec\EmagMarketplace\Model\Config\Source\ApiEndpoints;

/**
 * Class ApiClient
 * @package Zitec\EmagMarketplace\Model
 */
class ApiClient extends InstantiableClient
{
    /**
     * ApiClient constructor.
     *
     * @param LoggerInterface          $apiLogger
     * @param AlertManagerInterface    $alertManager
     * @param Config                   $config
     * @param StoreManagerInterface    $storeManager
     * @param ProductMetadataInterface $metadata
     * @param ModuleList               $moduleList
     * @param MagentoLogger            $logger
     * @param ApiEndpoints             $apiEndpoints
     */
    public function __construct(
        LoggerInterface $apiLogger,
        AlertManagerInterface $alertManager,
        Config $config,
        StoreManagerInterface $storeManager,
        ProductMetadataInterface $metadata,
        ModuleList $moduleList,
        MagentoLogger $logger,
        ApiEndpoints $apiEndpoints
    ) {
        // APi Endpoint
        $apiEndpoint = $config->getApiUrl();

        // API Endpoint validation
        if ( ! in_array($apiEndpoint, array_column($apiEndpoints->toOptionArray(), 'value'))) {
            $apiEndpoint = '';
        }

        parent::__construct(
            $apiEndpoint,
            $config->getApiUsername(),
            $config->getApiPassword(),
            $apiLogger,
            $alertManager
        );

        try {
            $siteUrl = $storeManager->getStore()->getBaseUrl();
        } catch (NoSuchEntityException $exception) {
            $logger->critical($exception);
            $siteUrl = null;
        }

        $this->setDebugInfo(
            $siteUrl,
            $metadata->getName() . ' ' . $metadata->getEdition(),
            $metadata->getVersion(),
            $moduleList->getOne('Zitec_EmagMarketplace')['setup_version'] ?? 'unknown'
        );
    }
}
