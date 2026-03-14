<?php

namespace Zitec\EmagMarketplace\Setup\Traits;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryInterface;
use Zitec\EmagMarketplace\Api\Data\CategoryMappingInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicInterface;
use Zitec\EmagMarketplace\Api\Data\CharacteristicMappingInterface;

/**
 * Trait CategoriesSchemaTrait
 * @package Zitec\EmagMarketplace\Setup\Traits
 */
trait CategoriesSchemaTrait
{
    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function createCategoriesTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(CategoryInterface::TABLE);
        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                CategoryInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Category ID'
            )
            ->addColumn(
                CategoryInterface::EMAG_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag Category ID'
            )
            ->addColumn(
                CategoryInterface::NAME,
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Category Name'
            )
            ->addColumn(
                CategoryInterface::IS_EAN_MANDATORY,
                Table::TYPE_BOOLEAN,
                null,
                ['default' => 0,],
                'Is EAN Mandatory'
            );

        $table->addIndex(
            $setup->getIdxName('emkp_categories_emag_category_id', [CategoryInterface::EMAG_ID]),
            [CategoryInterface::EMAG_ID],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        );

        $setup->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function createCharacteristicsTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(CharacteristicInterface::TABLE);
        $table = $setup->getConnection()->newTable($tableName)
            ->addColumn(
                CharacteristicInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Characteristic ID'
            )
            ->addColumn(
                CharacteristicInterface::EMAG_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag Characteristic ID'
            )
            ->addColumn(
                CharacteristicInterface::NAME,
                Table::TYPE_TEXT,
                60,
                ['nullable' => false,],
                'Characteristic Name'
            )
            ->addColumn(
                CharacteristicInterface::CATEGORY_EMAG_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Parent Category Emag Id'
            )
            ->addColumn(
                CharacteristicInterface::IS_MANDATORY,
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => 0,],
                'Is characterstic mandatory'
            )
            ->addColumn(
                CharacteristicInterface::ALLOW_NEW_VALUE,
                Table::TYPE_BOOLEAN,
                null,
                ['default' => 0,],
                'Characteristic accepts new values to be submitted'
            )
            ->addColumn(
                CharacteristicInterface::VALUES,
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true,],
                'Values'
            );

        $table
            ->addIndex(
                $setup->getIdxName($tableName, [CharacteristicInterface::EMAG_ID]),
                [CharacteristicInterface::EMAG_ID, CharacteristicInterface::CATEGORY_EMAG_ID],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            );

        $table->addForeignKey(
            $setup->getFkName(
                $tableName,
                CharacteristicInterface::CATEGORY_EMAG_ID,
                CategoryInterface::TABLE,
                CategoryInterface::EMAG_ID
            ),
            CharacteristicInterface::CATEGORY_EMAG_ID,
            $setup->getTable(CategoryInterface::TABLE),
            CategoryInterface::EMAG_ID,
            Table::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function createCategoriesMappingTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(CategoryMappingInterface::TABLE))
            ->addColumn(
                CategoryMappingInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Category ID'
            )
            ->addColumn(
                CategoryMappingInterface::EMAG_CATEGORY_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag Category ID'
            )
            ->addColumn(
                CategoryMappingInterface::MAGENTO_CATEGORY_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Magento Category ID'
            );

        $table
            ->addIndex(
                $setup->getIdxName(
                    'emkp_categories_magento_category_id',
                    [CategoryMappingInterface::EMAG_CATEGORY_ID]
                ),
                [CategoryMappingInterface::EMAG_CATEGORY_ID]
            )
            ->addIndex(
                $setup->getIdxName(
                    'emkp_categories_magento_category_id',
                    [CategoryMappingInterface::MAGENTO_CATEGORY_ID])
                ,
                [CategoryMappingInterface::MAGENTO_CATEGORY_ID]
            );

        $table
            ->addForeignKey(
                $setup->getFkName(
                    'zitec_emkp_categories_mapping',
                    CategoryMappingInterface::EMAG_CATEGORY_ID,
                    CategoryInterface::TABLE,
                    CategoryInterface::ID
                ),
                CategoryMappingInterface::EMAG_CATEGORY_ID,
                $setup->getTable(CategoryInterface::TABLE),
                CategoryInterface::ID,
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    'zitec_emkp_categories_mapping',
                    CategoryMappingInterface::MAGENTO_CATEGORY_ID,
                    'catalog_category_entity',
                    'entity_id'
                ),
                CategoryMappingInterface::MAGENTO_CATEGORY_ID,
                $setup->getTable('catalog_category_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function createCharacteristicsMappingTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable($setup->getTable(CharacteristicMappingInterface::TABLE))
            ->addColumn(
                CharacteristicMappingInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
                'Category ID'
            )
            ->addColumn(
                CharacteristicMappingInterface::MAPPING_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Category Mapping ID'
            )
            ->addColumn(
                CharacteristicMappingInterface::EMAG_CHARACTERISTIC_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Emag Characteristic ID'
            )
            ->addColumn(
                CharacteristicMappingInterface::MAGENTO_ATTRIBUTE_ID,
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'unsigned' => true,],
                'Magento Attribute ID'
            );

        $table
            ->addIndex(
                $setup->getIdxName(
                    'emkp_characteristic_mapping_mapping_id',
                    [CharacteristicMappingInterface::MAPPING_ID]
                ),
                [CharacteristicMappingInterface::MAPPING_ID]
            )
            ->addIndex(
                $setup->getIdxName(
                    'emkp_characteristic_mapping_emag_characteristic_id',
                    [CharacteristicMappingInterface::EMAG_CHARACTERISTIC_ID]
                ),
                [CharacteristicMappingInterface::EMAG_CHARACTERISTIC_ID]
            )
            ->addIndex(
                $setup->getIdxName(
                    'emkp_characteristic_mapping_magento_attribute_id',
                    [CharacteristicMappingInterface::MAGENTO_ATTRIBUTE_ID]
                ),
                [CharacteristicMappingInterface::MAGENTO_ATTRIBUTE_ID]
            );


        $table
            ->addForeignKey(
                $setup->getFkName(
                    CharacteristicMappingInterface::TABLE,
                    CharacteristicMappingInterface::MAPPING_ID,
                    CategoryMappingInterface::TABLE,
                    CategoryInterface::ID
                ),
                CharacteristicMappingInterface::MAPPING_ID,
                $setup->getTable(CategoryMappingInterface::TABLE),
                CategoryInterface::ID,
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    CharacteristicMappingInterface::TABLE,
                    CharacteristicMappingInterface::EMAG_CHARACTERISTIC_ID,
                    CharacteristicInterface::TABLE,
                    CharacteristicInterface::ID
                ),
                CharacteristicMappingInterface::EMAG_CHARACTERISTIC_ID,
                $setup->getTable(CharacteristicInterface::TABLE),
                CharacteristicInterface::ID,
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    CharacteristicMappingInterface::TABLE,
                    CharacteristicMappingInterface::MAGENTO_ATTRIBUTE_ID,
                    'catalog_eav_attribute',
                    'attribute_id'
                ),
                CharacteristicMappingInterface::MAGENTO_ATTRIBUTE_ID,
                $setup->getTable('catalog_eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);
    }
}
