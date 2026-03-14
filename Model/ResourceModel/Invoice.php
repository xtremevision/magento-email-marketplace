<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\InvoiceInterface;

/**
 * Class Invoice
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class Invoice extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('zitec_emkp_invoices', InvoiceInterface::ID);
    }
}
