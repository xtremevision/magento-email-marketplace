<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class SendEmail
 *
 * @package Zitec\Opportunity\Model
 */
class SendEmail
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * SendEmail constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder
    ) {
        $this->scopeConfig      = $scopeConfig;
        $this->storeManager     = $storeManager;
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * Send Email
     *
     * @param string $recipient
     * @param array $templateVars
     * @param string $emailTemplate
     *
     * @return void
     * 
     * @throws \Magento\Framework\Exception\MailException
     */
    public function send(string $recipient, array $templateVars, string $emailTemplate)
    {
        $store = $this->storeManager->getStore();

        $templateVars['store'] = $store;

        $this->transportBuilder->setTemplateIdentifier($emailTemplate);
        $this->transportBuilder->setTemplateOptions(
            [
                'area'  => Area::AREA_FRONTEND,
                'store' => $store->getId(),
            ]
        );
        $this->transportBuilder->setTemplateVars($templateVars);

        $email = $this->scopeConfig->getValue('trans_email/ident_support/email', ScopeInterface::SCOPE_STORE);
        $name  = $this->scopeConfig->getValue('trans_email/ident_support/name', ScopeInterface::SCOPE_STORE);

        $this->transportBuilder->setFrom(
            [
                'email' => $email,
                'name'  => $name,
            ]
        );

        $this->transportBuilder->addTo($recipient);
        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }
}