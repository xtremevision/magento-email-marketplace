<?php

namespace Zitec\EmagMarketplace\Cron;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Model\AlertManager;
use Zitec\EmagMarketplace\Model\Queue\Order\Importer;

/**
 * Class ImportOrders
 * @package Zitec\EmagMarketplace\Cron
 */
class ImportOrders
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    
    /**
     * @var Importer
     */
    protected $importer;
    
    /**
     * @var AlertManager
     */
    protected $alertManager;

    /**
     * ImportOrders constructor.
     *
     * @param State $state
     * @param Importer $importer
     * @param LoggerInterface $logger
     * @param AlertManager $alertManager
     */
    public function __construct(
        State $state,
        Importer $importer,
        LoggerInterface $logger,
        AlertManager $alertManager
    ) {
        try {
            $state->setAreaCode(Area::AREA_CRONTAB);
        } catch (\Throwable$exception) {
        }

        $this->logger   = $logger;
        $this->importer = $importer;
        $this->alertManager = $alertManager;
    }

    /**
     * Run Cron
     */
    public function execute()
    {
        try {
            $this->importer->importOrders();
        } catch (\Throwable $exception) {
            $this->alertManager->alert(
                'curl_error',
                __($exception->getMessage()) . $exception->getMessage()
                );
            $this->logger->critical($exception);
        }
    }
}
