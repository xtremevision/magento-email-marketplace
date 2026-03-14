<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface VatInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface VatInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const VAT_RATE = 'vat_rate';
    const IS_DEFAULT = 'is_default';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int
     */
    public function getEmagId(): int;

    /**
     * @param int $emagId
     *
     * @return self
     */
    public function setEmagId(int $emagId);

    /**
     * @return float
     */
    public function getVatRate(): float;

    /**
     * @param float $vatRate
     *
     * @return mixed
     */
    public function setVatRate(float $vatRate);

    /**
     * @return bool
     */
    public function getIsDefault(): bool;

    /**
     * @param bool $isDefault
     *
     * @return self
     */
    public function setIsDefault(bool $isDefault);
}
