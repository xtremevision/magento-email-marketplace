<?php

namespace Zitec\EmagMarketplace\Model\Awb;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Zitec\EmagMarketplace\Model\Json;
use Zitec\EmagMarketplace\Model\OrderAttributes;
use Zitec\EmagMarketplace\Model\ResourceModel\Awb\Collection;
use Zitec\EmagMarketplace\Model\ResourceModel\Awb\CollectionFactory;

/**
 * Class DataProvider
 * @package Zitec\EmagMarketplace\Model\Awb
 */
class DataProvider extends AbstractDataProvider
{
    const DEFAULT_ENVELOPE_NUMBER = 0;
    const DEFAULT_PARCEL_NUMBER = 1;

    /**
     * @var array
     */
    protected static $booleanFields = [
        'pickup_and_return',
        'saturday_delivery',
        'person_type',
        'sameday_delivery',
    ];

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData = [];

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Registry $registry
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->registry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        /** @var Order|null $order */
        $order = $this->registry->registry('current_order');

        if (!$order->getId()) {
            return [];
        }

        $emagOrderData = $order->getData(OrderAttributes::EMAG_ORDER_DATA);

        $shippingAddress = $order->getShippingAddress();

        if (!$shippingAddress || !$emagOrderData) {
            return [];
        }

        $emagOrderData = Json::json_decode($emagOrderData, true);

        $data = $this->dataPersistor->get('awb_form_data');

        if (!empty($data)) {
            $this->dataPersistor->clear('awb_form_data');
        } else {
            $data = [
                'order_id' => $order->getId(),
                'envelope_number' => self::DEFAULT_ENVELOPE_NUMBER,
                'parcel_number' => self::DEFAULT_PARCEL_NUMBER,
                'cod' => $this->getCashOnDelivery($order, $emagOrderData),
                'weight' => $order->getWeight(),
                'person_type' => $this->getPersonType($emagOrderData),
                'name' => $shippingAddress->getName(),
                'contact' => $emagOrderData['customer']['shipping_contact'],
                'phone1' => $shippingAddress->getTelephone(),
                'street' => implode(', ', $shippingAddress->getStreet()),
                'zipcode' => (! empty($shippingAddress->getPostcode()) ?
                    $shippingAddress->getPostcode() :
                    $emagOrderData['customer']['shipping_postal_code']),
                'locality_id' => $emagOrderData['customer']['shipping_locality_id'],
            ];
        }

        foreach (self::$booleanFields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $data[$field] == 1 || $data[$field] == 'true';
            }
        }

        $this->loadedData = [
            null => $data,
        ];

        return $this->loadedData;
    }

    /**
     * @param Order $order
     * @param array $emagOrderData
     * @return float|int
     */
    protected function getCashOnDelivery(Order $order, array $emagOrderData)
    {
        $result = 0;
        if (array_key_exists('payment_mode_id',
                $emagOrderData) && $emagOrderData['payment_mode_id'] == OrderAttributes::EMAG_PAYMENT_COD_ID
        ) {
            $result = $order->getGrandTotal();
        }
        return $result;
    }

    /**
     * @param array $emagOrderData
     * @return bool
     */
    protected function getPersonType(array $emagOrderData)
    {
        return array_key_exists('customer', $emagOrderData) &&
            array_key_exists('legal_entity', $emagOrderData['customer']) &&
            $emagOrderData['customer']['legal_entity'] === 1;
    }
}
