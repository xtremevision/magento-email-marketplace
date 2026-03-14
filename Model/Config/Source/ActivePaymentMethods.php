<?php

namespace Zitec\EmagMarketplace\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Payment\Model\Config;

/**
 * Class ActivePaymentMethods
 * @package Zitec\EmagMarketplace\Model\Config\Source
 */
class ActivePaymentMethods implements ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $appConfigScopeConfigInterface;
    
    /**
     * @var Config
     */
    protected $paymentModelConfig;

    /**
     * ActivePaymentMethods constructor.
     *
     * @param ScopeConfigInterface $appConfigScopeConfigInterface
     * @param Config $paymentModelConfig
     */
    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface,
        Config $paymentModelConfig
    ) {
        $this->appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
        $this->paymentModelConfig            = $paymentModelConfig;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $methods  = [];
        $payments = $this->paymentModelConfig->getActiveMethods();

        if (!$payments) {
            return $methods;
        }

        $payments = array_keys($payments);

        foreach ($payments as $paymentCode) {
            $paymentTitle          = $this->appConfigScopeConfigInterface->getValue(
                'payment/' . $paymentCode . '/title'
            );
            $methods[$paymentCode] = [
                'label' => $paymentTitle,
                'value' => $paymentCode,
            ];
        }

        return $methods;
    }
}
