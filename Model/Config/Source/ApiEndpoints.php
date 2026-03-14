<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class ApiEndpoints
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class ApiEndpoints implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'https://marketplace.emag.ro/api-3', 'label' => __('Romania')],
            ['value' => 'https://marketplace.emag.bg/api-3', 'label' => __('Bulgaria')],
            ['value' => 'https://marketplace.emag.hu/api-3', 'label' => __('Hungary')],
            ['value' => 'https://marketplace.emag.pl/api-3', 'label' => __('Poland')],
        ];
    }
}
