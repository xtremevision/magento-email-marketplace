<?php

namespace Zitec\EmagMarketplace\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Zitec\EmagMarketplace\Setup\Traits\OrderDataTrait;
use Zitec\EmagMarketplace\Setup\Traits\ProductDataTrait;

/**
 * Class InstallData
 * @package Zitec\EmagMarketplace\Setup
 */
class InstallData implements InstallDataInterface
{
    use ProductDataTrait;
    use OrderDataTrait;

    /**
     * @var EavSetupFactory
     */
    protected $setupFactory;
    
    /**
     * @var SalesSetupFactory
     */
    protected $salesSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $setupFactory
     * @param SalesSetupFactory $salesSetupFactory
     */
    public function __construct(
        EavSetupFactory $setupFactory,
        SalesSetupFactory $salesSetupFactory
    )
    {
        $this->setupFactory = $setupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $setup */
        $productSetup = $this->setupFactory->create(['setup' => $setup]);

        $this->createProductAttributes($productSetup);

        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);

        $this->createOrderAttributes($salesSetup);
    }
}
