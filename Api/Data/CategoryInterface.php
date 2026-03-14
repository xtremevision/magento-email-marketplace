<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface CategoryInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface CategoryInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const NAME = 'name';
    const IS_EAN_MANDATORY = 'is_ean_mandatory';

    const TABLE = 'zitec_emkp_categories';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $emagId
     * @return CategoryInterface
     */
    public function setEmagId(int $emagId);

    /**
     * @return int|null
     */
    public function getEmagId(): int;

    /**
     * @param null|string $name
     * @return CategoryInterface
     */
    public function setName(string $name);

    /**
     * @return null|string
     */
    public function getName();

    /**
     * @param bool $isEanMandatory
     * @return CategoryInterface
     */
    public function setIsEanMandatory(bool $isEanMandatory);

    /**
     * @return bool
     */
    public function isEanMandatory(): bool;
}
