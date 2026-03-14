<?php

namespace Zitec\EmagMarketplace\Api;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Model\Awb;

/**
 * Interface AwbRepositoryInterface
 * @package Zitec\EmagMarketplace\Api
 */
interface AwbRepositoryInterface
{
    /**
     * @param Awb $awb
     *
     * @throws \Exception
     * @throws AlreadyExistsException
     */
    public function save(Awb $awb);

    /**
     * @param int $id
     * @return Awb
     * @throws NoSuchEntityException
     */
    public function getById(int $id): Awb;
}
