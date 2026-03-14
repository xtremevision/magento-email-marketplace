<?php

namespace Zitec\EmagMarketplace\Setup\Traits;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\DB\Ddl\Table;
use Magento\Sales\Model\Order;
use Zitec\EmagMarketplace\Model\OrderAttributes;

/**
 * Trait OrderDataTrait
 * @package Zitec\EmagMarketplace\Setup\Traits
 */
trait OrderDataTrait
{
    protected $orderAttributes = [
        OrderAttributes::IS_EMAG_ORDER => [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Is an eMAG order',
            'input' => 'boolean',
            'class' => '',
            'source' => '',
            'group' => 'eMag Marketplace',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => 0,
            'used_in_product_listing' => false,
            'unique' => false,
        ],
        OrderAttributes::EMAG_ORDER_ID => [
            'type' => 'bigint',
            'backend' => '',
            'frontend' => '',
            'label' => 'eMAG Order Id',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'group' => '',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => false,
            'filterable' => true,
            'required' => false,
            'is_used_in_grid' => true,
            'user_defined' => false,
            'default' => NULL,
            'used_in_product_listing' => false,
            'unique' => false,
        ],
        OrderAttributes::EMAG_ORDER_DATA => [
            'type' => 'text',
            'backend' => '',
            'frontend' => '',
            'label' => 'Emag imported order json data',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'group' => 'eMag Marketplace',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => false,
            'required' => false,
            'user_defined' => false,
            'used_in_product_listing' => false,
            'unique' => false,
        ]
    ];

    /**
     * @param EavSetup $setup
     */
    public function createOrderAttributes(EavSetup $setup)
    {
        foreach ($this->orderAttributes as $name => $attribute) {
            $setup->removeAttribute(Order::ENTITY, $name);
            $setup->addAttribute(Order::ENTITY, $name, $attribute);
        }

        $setup->getSetup()->getConnection()->addColumn(
            $setup->getSetup()->getTable('sales_order_grid'),
            OrderAttributes::EMAG_ORDER_ID,
            [
                'type' => Table::TYPE_BIGINT,
                'comment' =>'Emag Order Id'
            ]
        );
    }
}
