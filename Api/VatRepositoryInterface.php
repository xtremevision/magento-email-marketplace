<?php

namespace Zitec\EmagMarketplace\Api;

use Zitec\EmagMarketplace\Model\Vat;

/**
 * Interface VatRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface VatRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function updateData(array $data): bool;

    /**
     * @param int $id
     * @return Vat
     */
    public function getByEmagId(int $id): Vat;
}
