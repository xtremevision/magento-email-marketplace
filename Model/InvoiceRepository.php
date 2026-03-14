<?php

namespace Zitec\EmagMarketplace\Model;

use Zitec\EmagMarketplace\Api\Data\InvoiceInterface;
use Zitec\EmagMarketplace\Api\InvoiceRepositoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice as ResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Invoice\CollectionFactory;

/**
 * Class InvoiceRepository
 * @package Zitec\EmagMarketplace\Model
 */
class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    protected $resourceModel;
    
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * InvoiceRepository constructor.
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collection
     */
    public function __construct(
        ResourceModel $resourceModel,
        CollectionFactory $collection
    ) {
        $this->resourceModel = $resourceModel;
        $this->collection = $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Invoice $invoice)
    {
        $this->resourceModel->save($invoice);
    }

    /**
     * {@inheritDoc}
     */
    public function getInvoicesByEmagOrderId(int $id): Collection
    {
        return $this->collection->create()->addFieldToFilter(InvoiceInterface::EMAG_ORDER_ID, ['eq' => $id]);
    }
}
