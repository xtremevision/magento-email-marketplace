<?php

namespace Zitec\EmagMarketplace\Plugin;

use Magento\Framework\Registry;
use Magento\SalesRule\Model\Validator;
use Zitec\EmagMarketplace\Model\Queue\Order\Importer;

/**
 * Class SalesRuleValidator
 * @package Zitec\EmagMarketplace\Plugin
 */
class SalesRuleValidator
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
     * @param Validator $subject
     * @param bool $result
     * @return bool
     * 
     * @SuppressWarnings("unused")
     */
    public function afterCanApplyDiscount(Validator $subject, bool $result): bool
    {
        if ($this->registry->registry(Importer::IMPORTING_ORDER_FLAG)) {
            return false;
        }

        return $result;
    }
}