<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\AlreadyExistsException;
use Zitec\EmagMarketplace\Model\Invoice;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice\Collection;

/**
 * Interface InvoiceRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface InvoiceRepositoryInterface
{
    /**
     * @param Invoice $invoice
     *
     * @throws \Exception
     * @throws AlreadyExistsException
     */
    public function save(Invoice $invoice);

    /**
     * @param int $orderId
     * @return Collection
     */
    public function getInvoicesByEmagOrderId(int $orderId): Collection;
}
