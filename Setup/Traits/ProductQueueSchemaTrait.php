<?php

namespace Zitec\EmagMarketplace\Setup\Traits;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zitec\EmagMarketplace\Api\Data\ProductQueueItemInterface;

/**
 * Trait ProductQueueSchemaTrait
 * @package Zitec\EmagMarketplace\Setup\Traits
 */
trait ProductQueueSchemaTrait
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function createProductsQueueTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(ProductQueueItemInterface::TABLE))
            ->addColumn(ProductQueueItemInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Product Queue Entry ID'
            )
            ->addColumn(
                ProductQueueItemInterface::PRODUCT_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Magento Product ID'
            )
            ->addColumn(
                ProductQueueItemInterface::ACTION,
                Table::TYPE_TEXT,
                11,
                ['nullable' => false,],
                'Action'
            )
            ->addColumn(
                ProductQueueItemInterface::STATE,
                Table::TYPE_TEXT,
                11,
                ['nullable' => false, 'default' => ProductQueueItemInterface::STATE_PENDING,],
                'Synchronisation state'
            )
            ->addColumn(
                ProductQueueItemInterface::RESPONSE,
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true,],
                'Response Message'
            )
            ->addColumn(
                ProductQueueItemInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )
            ->addColumn(
                ProductQueueItemInterface::UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );

        $setup->getConnection()->createTable($table);
    }
}
