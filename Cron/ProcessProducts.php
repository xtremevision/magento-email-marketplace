<?php

namespace Zitec\EmagMarketplace\Cron;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Psr\Log\LoggerInterface;
use Zitec\EmagMarketplace\Model\Config;
use Zitec\EmagMarketplace\Model\Queue\Product\Handler;

/**
 * Class ProcessProducts
 * @package Zitec\EmagMarketplace\Cron
 */
class ProcessProducts
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
     * ProcessProducts constructor.
     * @param State $state
     * @param Config $config
     * @param Handler $handler
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        State $state,
        Config $config,
        Handler $handler,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger
    ) {
        try {
            $state->setAreaCode(Area::AREA_CRONTAB);
        } catch (\Throwable$exception) {
        }

        $this->config = $config;
        $this->handler = $handler;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
    }

    /**
     * Run cron
     */
    public function execute()
    {
        for ($i = 0; $i < $this->config->getQueueLimit(); $i++) {
            try {
                $result = $this->handler->handle();

                if (!$result) {
                    break;
                }
            } catch (\Throwable $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
