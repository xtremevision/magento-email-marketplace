<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Locale
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class Locale implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'ro_RO', 'label' => __('Romanian (Romania)')],
            ['value' => 'bg_BG', 'label' => __('Bulgarian (Bulgaria)')],
            ['value' => 'hu_HU', 'label' => __('Hungarian (Hungary)')],
            ['value' => 'pl_PL', 'label' => __('Polish (Poland)')],
        ];
    }
}
