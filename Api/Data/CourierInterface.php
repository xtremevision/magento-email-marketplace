<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface CourierInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface CourierInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const NAME = 'name';
    const DISPLAY_NAME = 'display_name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
     * @return $this
     */
    public function setEmagId(int $emagId);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * @param string $displayName
     *
     * @return self
     */
    public function setDisplayName(string $displayName);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(string $updatedAt);
}
