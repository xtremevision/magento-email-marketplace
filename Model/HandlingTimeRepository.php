<?php

namespace Zitec\EmagMarketplace\Model;

use Zitec\EmagMarketplace\Api\HandlingTimeRepositoryInterface;
use Zitec\EmagMarketplace\Model\HandlingTimeFactory;
use Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime\CollectionFactory;

/**
 * Class HandlingTimeRepository
 * @package Zitec\EmagMarketplace\Model
 */
class HandlingTimeRepository implements HandlingTimeRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $handlingTimeCollectionFactory;

    /**
     * @var \Zitec\EmagMarketplace\Model\HandlingTimeFactory
     */
    protected $handlingTimeFactory;

    /**
     * HandlingTimeRepository constructor.
     *
     * @param \Zitec\EmagMarketplace\Model\HandlingTimeFactory $handlingTimeFactory
     * @param CollectionFactory $handlingTimeCollectionFactory
     */
    public function __construct(
        HandlingTimeFactory $handlingTimeFactory,
        CollectionFactory $handlingTimeCollectionFactory
    ) {
        $this->handlingTimeCollectionFactory = $handlingTimeCollectionFactory;
        $this->handlingTimeFactory           = $handlingTimeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function updateData(array $data): bool
    {
        $handlingTimeCollection = $this->handlingTimeCollectionFactory->create();

        $importedEmagIds = [];

        foreach ($data as $result) {
            $itemData          = $this->processData($result);
            $importedEmagIds[] = $itemData['handling_time'];
            if ($exitingItem = $handlingTimeCollection->getItemByColumnValue(
                'handling_time',
                $itemData['handling_time']
            )
            ) {
                $item = $exitingItem;
            } else {
                $item = $this->handlingTimeFactory->create();
            }

            $item->addData($itemData);

            if (!$exitingItem) {
                $handlingTimeCollection->addItem($item);
            }
        }

        $handlingTimeCollection->save();

        $collectionToDelete = $this->handlingTimeCollectionFactory->create();
        $collectionToDelete->addFieldToFilter('handling_time', ['nin' => $importedEmagIds]);

        $collectionToDelete->walk('delete');
        
        return true;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function processData(array $data): array
    {
        return [
            'handling_time' => $data['id'],
        ];
    }
}
