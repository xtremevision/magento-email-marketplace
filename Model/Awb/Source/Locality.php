<?php

namespace Zitec\EmagMarketplace\Model\Awb\Source;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\LocalityRepositoryInterface;
use Magento\Framework\Registry;
use Zitec\EmagMarketplace\Model\Json;
use Zitec\EmagMarketplace\Model\OrderAttributes;

/**
 * Class Locality
 * @package Zitec\EmagMarketplace\Model\Awb\Source
 */
class Locality implements OptionSourceInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var LocalityRepositoryInterface
     */
    protected $localityRepository;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Locality constructor.
     *
     * @param DataPersistorInterface $dataPersistor
     * @param LocalityRepositoryInterface $localityRepository
     * @param Escaper $escaper
     * @param Registry $registry
     */
    public function __construct(
        DataPersistorInterface $dataPersistor,
        LocalityRepositoryInterface $localityRepository,
        Escaper $escaper,
        Registry $registry
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->localityRepository = $localityRepository;
        $this->escaper = $escaper;
        $this->registry = $registry;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $formData = $this->dataPersistor->get('awb_form_data');

        if (!isset($formData['locality_id'])) {
            $order = $this->registry->registry('current_order');

            if (!$order->getId()) {
                return [];
            }

            $emagOrderData = $order->getData(OrderAttributes::EMAG_ORDER_DATA);
            $emagOrderData = Json::json_decode($emagOrderData, true);

            if (array_key_exists('customer', $emagOrderData) &&
                array_key_exists('shipping_locality_id', $emagOrderData['customer']) &&
                $emagOrderData['customer']['shipping_locality_id']
            ) {
                $formData['locality_id'] = $emagOrderData['customer']['shipping_locality_id'];
            } else {
                return [];
            }
        }

        try {
            $locality = $this->localityRepository->getByEmagId($formData['locality_id']);

            $locality = $locality->getFirstItem();

            if ($locality->getId()) {
                return [
                    [
                        'label' => $this->escaper->escapeHtml($locality->getName() . ' (' . $locality->getRegion() . ')'),
                        'value' => $locality->getEmagId(),
                    ]
                ];
            } else {
                return [];
            }
        } catch (NoSuchEntityException $exception) {
            return [];
        }
    }
}
