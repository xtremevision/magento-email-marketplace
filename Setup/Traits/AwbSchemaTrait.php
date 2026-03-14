<?php

namespace Zitec\EmagMarketplace\Setup\Traits;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zitec\EmagMarketplace\Api\Data\AwbInterface;

trait AwbSchemaTrait
{
    /**
     * Installs data for a module
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function createAwbsTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable('zitec_emkp_awbs'))
            ->addColumn(AwbInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Entity ID'
            )
            ->addColumn(
                AwbInterface::EMAG_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag ID'
            )
            ->addColumn(
                AwbInterface::ORDER_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Order ID'
            )
            ->addColumn(
                AwbInterface::COURIER_NAME,
                Table::TYPE_TEXT,
                null,
                ['nullable' => false,],
                'Courier Name'
            )
            ->addColumn(
                AwbInterface::AWB_NUMBER,
                Table::TYPE_TEXT,
                null,
                ['nullable' => false,],
                'AWB Number'
            )
            ->addColumn(
                AwbInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            );

        $table->addIndex(
            $setup->getIdxName('emkp_awbs_emag_id', [AwbInterface::EMAG_ID]),
            [AwbInterface::EMAG_ID],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        );

        $table->addForeignKey(
            $setup->getFkName(
                $setup->getTable('zitec_emkp_awbs'),
                AwbInterface::ORDER_ID,
                $setup->getTable('sales_order'),
                AwbInterface::EMAG_ID
            ),
            AwbInterface::ORDER_ID,
            $setup->getTable('sales_order'),
            'entity_id',
            Table::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($table);
    }
}
