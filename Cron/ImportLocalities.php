<?php

namespace Zitec\EmagMarketplace\Cron;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Api\LocalityRepositoryInterface;
use Zitec\EmagMarketplace\Model\AlertManager;

/**
 * Class ImportLocalities
 * @package Zitec\EmagMarketplace\Cron
 */
class ImportLocalities
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    
    /**
     * @var AlertManager
     */
    protected $alertManager;

    /**
     * @var LocalityRepositoryInterface
     */
    protected $localityRepository;

    /**
     * @var array
     */
    protected $localities;

    /**
     * ImportOrders constructor.
     *
     * @param State $state
     * @param LocalityRepositoryInterface $localityRepository
     * @param LoggerInterface $logger
     * @param AlertManager $alertManager
     * @internal param Importer $importer
     */
    public function __construct(
        State $state,
        LocalityRepositoryInterface $localityRepository,
        LoggerInterface $logger,
        AlertManager $alertManager
    ) {
        try {
            $state->setAreaCode(Area::AREA_CRONTAB);
        } catch (\Throwable$exception) {
        }

        $this->logger   = $logger;
        $this->alertManager = $alertManager;
        $this->localityRepository = $localityRepository;
    }

    /**
     * Run Cron
     */
    public function execute()
    {
        try {
            $this->localities = $this->localityRepository->fetchData();

            $this->localityRepository->updateData($this->localities);
        } catch (\Throwable $exception) {
            $this->alertManager->alert(
                'curl_error',
                __($exception->getMessage()) . $exception->getMessage()
                );
            $this->logger->critical($exception);
        }
    }
}
