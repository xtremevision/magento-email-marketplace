<?php

namespace Zitec\EmagMarketplace\Plugin;

use Magento\Framework\Registry;
use Magento\SalesRule\Model\Utility;
use Zitec\EmagMarketplace\Model\Queue\Order\Importer;

/**
 * Class SalesShippingRuleValidator
 * @package Zitec\EmagMarketplace\Plugin
 */
class SalesShippingRuleValidator
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * SalesRuleValidator constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param Utility $object
     * @param bool $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterCanProcessRule(Utility $object, bool $result): bool
    {
        if ($this->registry->registry(Importer::IMPORTING_ORDER_FLAG)) {
            return false;
        }

        return $result;
    }
}