<?php

namespace Zitec\EmagMarketplace\Api;

use Zitec\EmagMarketplace\Model\ResourceModel\Courier\Collection;

/**
 * Interface CourierRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface CourierRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function updateData(array $data): bool;

    /**
     * @return Collection
     */
    public function getAll(): Collection;
}
