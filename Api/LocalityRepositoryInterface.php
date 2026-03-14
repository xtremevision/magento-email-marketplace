<?php

namespace Zitec\EmagMarketplace\Api;

use Zitec\EmagMarketplace\ApiWrapper\Exceptions\FailedRequestException;
use Zitec\EmagMarketplace\ApiWrapper\Exceptions\MissingEndpointException;
use Zitec\EmagMarketplace\Model\ResourceModel\Locality\Collection;

/**
 * Interface LocalityRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface LocalityRepositoryInterface
{
    const LOCALITIES_PER_PAGE = 300;
    
    /**
     * @param array $data
     *
     * @return bool
     * 
     * @throws \Exception
     */
    public function updateData(array $data): bool;

    /**
     * @param array $terms
     *
     * @return Collection
     */
    public function search(array $terms): Collection;

    /**
     * @param array $data
     *
     * @return void
     *
     * @throws \Exception
     */
    public function updateLocalitiesData(array $data);

    /**
     * @return array
     * 
     * @throws \InvalidArgumentException
     * @throws FailedRequestException
     * @throws MissingEndpointException
     */
    public function fetchData(): array;

    /**
     * @param int $emagId
     * @return Collection
     */
    public function getByEmagId(int $emagId): Collection;
}
