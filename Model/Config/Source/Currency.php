<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Currency
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class Currency implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array 
    {
        return [
            ['value' => 'RON', 'label' => __('Romanian Leu')],
            ['value' => 'BGN', 'label' => __('Bulgarian Lev')],
            ['value' => 'HUF', 'label' => __('Hungarian Forint')],
            ['value' => 'PLN', 'label' => __('Polish Zloty')],
        ];
    }
}
