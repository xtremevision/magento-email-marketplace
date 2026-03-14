<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface HandlingTimeInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface HandlingTimeInterface
{
    const ID = 'id';
    const EMAG_HANDLING_TIME_ID = 'emag_handling_time_id';
    const HANDLING_TIME = 'handling_time';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return float
     */
    public function getHandlingTime(): float;

    /**
     * @param float $handlingTime
     *
     * @return self
     */
    public function setHandlingTime(float $handlingTime);
}
