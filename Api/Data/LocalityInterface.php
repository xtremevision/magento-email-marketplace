<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface LocalityInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface LocalityInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const NAME = 'name';
    const REGION = 'region';
    const REGION3 = 'region3';
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
     * @return self
     */
    public function setEmagId($emagId);

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
    public function getRegion(): string;

    /**
     * @return string
     */
    public function getRegion3(): string;

    /**
     * @param string $region
     *
     * @return self
     */
    public function setRegion(string $region);

    /**
     * @param string $region
     *
     * @return self
     */
    public function setRegion3(string $region);

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
