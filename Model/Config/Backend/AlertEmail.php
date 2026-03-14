<?php

namespace Zitec\EmagMarketplace\Model\Config\Backend;

use Magento\Framework\App\Config\Value;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class AlertEmail
 * @package Zitec\EmagMarketplace\Model\Config\Backend
 */
class AlertEmail extends Value
{
    /**
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();

        if (empty($value)) {
            return;
        }

        $emails = explode(',', $value);
        
        if (!$emails) {
            return;
        }

        foreach ($emails as $email) {
            if (!\Zend_Validate::is(trim($email), 'EmailAddress')) {
                throw new LocalizedException(
                    __('Please enter valid email addresses, separated by comma.')
                );
            }
        }
    }
}
