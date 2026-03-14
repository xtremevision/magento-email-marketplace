<?php

namespace Zitec\EmagMarketplace\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zitec\EmagMarketplace\Setup\Traits\AwbSchemaTrait;
use Zitec\EmagMarketplace\Setup\Traits\CategoriesSchemaTrait;
use Zitec\EmagMarketplace\Setup\Traits\ProductQueueSchemaTrait;

/**
 * Class InstallSchema
 * @package Zitec\EmagMarketplace\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    use CategoriesSchemaTrait,
        ProductQueueSchemaTrait,
        AwbSchemaTrait;

    /**
     * @var EmagMarketplaceSchemaSetup
     */
    protected $emkpSchemaSetup;

    /**
     * InstallSchema constructor.
     * @param EmagMarketplaceSchemaSetup $schemaSetup
     */
    public function __construct(EmagMarketplaceSchemaSetup $schemaSetup)
    {
        $this->emkpSchemaSetup = $schemaSetup;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->emkpSchemaSetup->createHandlingTimesTable($installer);
        $this->emkpSchemaSetup->createVatRateTable($installer);
        $this->emkpSchemaSetup->createCouriersTable($installer);
        $this->emkpSchemaSetup->createLocalitiesTable($installer);
        $this->emkpSchemaSetup->createOrderInvoicesTable($installer);
        $this->emkpSchemaSetup->createOrdersQueueTable($installer);

        $this->createCategoriesTable($installer);
        $this->createCharacteristicsTable($installer);
        $this->createCategoriesMappingTable($installer);
        $this->createCharacteristicsMappingTable($installer);
        $this->createProductsQueueTable($installer);
        $this->createAwbsTable($installer);

        $installer->endSetup();
    }
}
