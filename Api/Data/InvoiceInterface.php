<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface InvoiceInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface InvoiceInterface
{
    const ID = 'id';
    const EMAG_ORDER_ID = 'emag_order_id';
    const PATH = 'path';
    const URL = 'url';
    const CREATED_AT = 'created_at';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int
     */
    public function getEmagOrderId(): int;

    /**
     * @param int $emagOrderId
     *
     * @return self
     */
    public function setEmagOrderId(int $emagOrderId);

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path);

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     * @return self
     */
    public function setUrl(string $url);

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
}
