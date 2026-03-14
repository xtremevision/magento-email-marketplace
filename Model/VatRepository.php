<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\Data\VatInterface;
use Zitec\EmagMarketplace\Api\VatRepositoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Vat as ResourceModel;
use Zitec\EmagMarketplace\Model\ResourceModel\Vat\CollectionFactory;

/**
 * Class VatRepository
 * @package Zitec\EmagMarketplace\Model
 */
class VatRepository implements VatRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $vatCollectionFactory;
    
    /**
     * @var VatFactory
     */
    protected $vatFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * VatRepository constructor.
     *
     * @param \Zitec\EmagMarketplace\Model\VatFactory $vatFactory
     * @param CollectionFactory $vatCollectionFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        VatFactory $vatFactory,
        CollectionFactory $vatCollectionFactory,
        ResourceModel $resourceModel
    ) {
        $this->vatCollectionFactory = $vatCollectionFactory;
        $this->vatFactory           = $vatFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * {@inheritdoc}
     */
    public function updateData(array $data): bool
    {
        $vatCollection = $this->vatCollectionFactory->create();

        $importedEmagIds = [];

        foreach ($data as $result) {
            $importedEmagIds[] = $result['vat_id'];
            $vatData           = $this->processData($result);
            if ($exitingItem = $vatCollection->getItemByColumnValue('emag_id', $vatData['emag_id'])) {
                $item = $exitingItem;
            } else {
                $item = $this->vatFactory->create();
            }

            $item->addData($vatData);

            if (!$exitingItem) {
                $vatCollection->addItem($item);
            }
        }

        $vatCollection->save();

        $collectionToDelete = $this->vatCollectionFactory->create();
        $collectionToDelete->addFieldToFilter('emag_id', ['nin' => $importedEmagIds]);

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
            'emag_id'    => $data['vat_id'],
            'vat_rate'   => $data['vat_rate'],
            'is_default' => $data['is_default'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getByEmagId(int $id): Vat
    {
        $object = $this->vatFactory->create();

        $this->resourceModel->load($object, $id, VatInterface::EMAG_ID);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Vat Rate with eMag id "%1" does not exist.', $id));
        }

        return $object;
    }
}
