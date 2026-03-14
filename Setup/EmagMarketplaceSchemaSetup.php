<?php

namespace Zitec\EmagMarketplace\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class EmagMarketplaceSchemaSetup
 * @package Zitec\EmagMarketplace\Setup
 */
class EmagMarketplaceSchemaSetup
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function createHandlingTimesTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_handling_time'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Handling Time ID'
                       )->addColumn(
                'handling_time',
                Table::TYPE_FLOAT,
                null,
                ['nullable' => false,],
                'Handling Time value'
            )->addIndex(
                $setup->getIdxName('zitec_emkp_handling_time_handling_time', ['handling_time']),
                ['handling_time']
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * Creates table with
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    public function createVatRateTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_vat_rate'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Vat ID'
                       )->addColumn(
                'emag_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,],
                'Emag Vat ID'
            )->addColumn(
                'is_default',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false,],
                'Is default Vat Rate'
            )->addColumn(
                'vat_rate',
                Table::TYPE_FLOAT,
                null,
                ['nullable' => false,],
                'Is default Vat Rate'
            )->addIndex(
                $setup->getIdxName('zitec_emkp_vat_rate_emag_id', ['emag_id']),
                ['emag_id']
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * Installs data for a module
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    public function createCouriersTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_couriers'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Courier ID'
                       )->addColumn(
                'emag_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,],
                'Emag ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Courier Name'
            )->addColumn(
                'display_name',
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Courier Display Name'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->addIndex(
                $setup->getIdxName('zitec_emkp_couriers_emag_id', ['emag_id']),
                ['emag_id']
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * Installs data for a module
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    public function createLocalitiesTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_localities'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Courier ID'
                       )->addColumn(
                'emag_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,],
                'Emag Locality ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Courier Name'
            )->addColumn(
                'region',
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Region Name'
            )->addColumn(
                'region3',
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Region3 Name - Sector'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->addIndex(
                $setup->getIdxName('emkp_localities_emag_id', ['emag_id']),
                ['emag_id']
            );

        $setup->getConnection()->createTable($table);
    }


    /**
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    public function createOrderInvoicesTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_invoices'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Invoice ID'
                       )->addColumn(
                'emag_order_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false,],
                'Emag Order ID'
            )->addColumn(
                'path',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false,],
                'Invoice Path'
            )->addColumn(
                'url',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false,],
                'Invoice Url'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            )->addIndex(
                $setup->getIdxName('emkp_invoices_emag_id', ['emag_order_id']),
                ['emag_order_id']
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * Installs data for a module
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    public function createOrdersQueueTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable('zitec_emkp_order_queue'))
                       ->addColumn(
                           'id',
                           Table::TYPE_INTEGER,
                           null,
                           ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                           'Order Queue Entry ID'
                       )->addColumn(
                'emag_id',
                Table::TYPE_BIGINT,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag Order ID'
            )->addColumn(
                'magento_id',
                Table::TYPE_TEXT,
                50,
                ['nullable' => false, 'unsigned' => true,],
                'Magento Order ID'
            )->addColumn(
                'status',
                Table::TYPE_TEXT,
                12,
                ['nullable' => false,],
                'Synchronisation status'
            )->addColumn(
                'message',
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => false,],
                'Request response'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->addIndex(
                $setup->getIdxName('emkp_order_queue_magento_id', ['magento_id']),
                ['magento_id']
            );

        $setup->getConnection()->createTable($table);
    }
}
