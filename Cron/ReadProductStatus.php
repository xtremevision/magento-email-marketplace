<?php

namespace Zitec\EmagMarketplace\Cron;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Model\AlertManager;
use Zitec\EmagMarketplace\Model\ProductStatus;

/**
 * Class ProcessProducts
 * @package Zitec\EmagMarketplace\Cron
 */
class ReadProductStatus
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Handler
     */
    protected $handler;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var AlertManager
     */
    protected $alertManager;

    /**
     * ReadProductStatus constructor.
     * @param State $state
     * @param ProductStatus $status
     * @param LoggerInterface $logger
     * @param AlertManager $alertManager
     */
    public function __construct(
        State $state,
        ProductStatus $status,
        LoggerInterface $logger,
        AlertManager $alertManager
    ) {
        try {
            $state->setAreaCode(Area::AREA_CRONTAB);
        } catch (\Throwable$exception) {
        }
        
        $this->logger = $logger;
        $this->status = $status;
        $this->alertManager = $alertManager;
    }

    /**
     * Run cron
     */
    public function execute()
    {
        try {
            $this->status->importProductStatus();
        } catch (\Throwable $exception) {
            $this->alertManager->alert(
                'curl_error',
                __($exception->getMessage()) . $exception->getMessage()
            );
        }
    }
}
