<?php

namespace Zitec\EmagMarketplace\Model\Awb\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Zitec\EmagMarketplace\Api\CourierRepositoryInterface;
use Zitec\EmagMarketplace\Api\Data\CourierInterface;

/**
 * Class CourierAccounts
 * @package Zitec\EmagMarketplace\Model\Awb\Source
 */
class CourierAccounts implements OptionSourceInterface
{
    /**
     * @var CourierRepositoryInterface
     */
    protected $courierRepository;

    /**
     * CourierAccounts constructor.
     *
     * @param CourierRepositoryInterface $courierRepository
     */
    public function __construct(CourierRepositoryInterface $courierRepository)
    {
        $this->courierRepository = $courierRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $courierAccounts = [];

        /** @var CourierInterface $account */
        foreach ($this->courierRepository->getAll() as $account) {
            $courierAccounts[] = [
                'label' =>  $account->getDisplayName() . ' (' . $account->getName() . ')',
                'value' => $account->getEmagId(),
            ];
        }

        return $courierAccounts;
    }
}
