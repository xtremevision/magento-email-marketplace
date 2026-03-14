<?php

namespace Zitec\EmagMarketplace\Api;

/**
 * Interface HandlingTimeRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface HandlingTimeRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function updateData(array $data): bool;
}
