<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Zitec\EmagMarketplace\Api\CourierRepositoryInterface;
use Zitec\EmagMarketplace\Model\CourierFactory;
use Zitec\EmagMarketplace\Model\ResourceModel\Courier\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Courier\CollectionFactory;

/**
 * Class CourierRepository
 * @package Zitec\EmagMarketplace\Model
 */
class CourierRepository implements CourierRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $courierCollectionFactory;

    /**
     * @var \Zitec\EmagMarketplace\Model\CourierFactory
     */
    protected $courierFactory;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * CourierRepository constructor.
     *
     * @param \Zitec\EmagMarketplace\Model\CourierFactory $courierFactory
     * @param CollectionFactory $courierCollectionFactory
     * @param DateTime $date
     */
    public function __construct(
        CourierFactory $courierFactory,
        CollectionFactory $courierCollectionFactory,
        DateTime $date
    ) {
        $this->courierCollectionFactory = $courierCollectionFactory;
        $this->courierFactory           = $courierFactory;
        $this->date                     = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function updateData(array $data): bool
    {
        $courierCollection = $this->courierCollectionFactory->create();
        $importedEmagIds   = [];

        foreach ($data as $result) {
            $itemData          = $this->processData($result);
            $importedEmagIds[] = $itemData['emag_id'];

            if ($exitingItem = $courierCollection->getItemByColumnValue('emag_id', $itemData['emag_id'])) {
                $item = $exitingItem;
            } else {
                $item = $this->courierFactory->create();
            }

            $item->addData($itemData);

            if (!$exitingItem) {
                $courierCollection->addItem($item);
            }
        }

        $courierCollection->save();

        $collectionToDelete = $this->courierCollectionFactory->create();
        $collectionToDelete->addFieldToFilter('emag_id', ['nin' => $importedEmagIds]);

        $collectionToDelete->walk('delete');
        
        return true;
    }

    /**
     * @return Collection
     */
    public function getAll() : Collection
    {
        return $this->courierCollectionFactory->create();
    }


    /**
     * @param array $vat
     *
     * @return array
     */
    protected function processData(array $vat): array
    {
        return [
            'emag_id'      => $vat['account_id'],
            'name'         => $vat['courier_name'],
            'display_name' => $vat['account_display_name'],
            'created_at'   => $this->date->gmtDate()
        ];
    }
}
