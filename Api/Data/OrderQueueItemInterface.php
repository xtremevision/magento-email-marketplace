<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface OrderQueueItemInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface OrderQueueItemInterface
{
    const ID = 'id';

    const EMAG_ID = 'emag_id';
    const MAGENTO_ID = 'magento_id';

    const STATUS = 'status';
    const MESSAGE = 'message';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_PENDING = 'pending';
    const STATUS_SYNCHRONISED = 'synchronised';
    const STATUS_FAILED = 'failed';

    const TABLE = 'zitec_emkp_order_queue';

    /**
     * @return int
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
     * @return string
     */
    public function getMagentoId(): string;

    /**
     * @param string $magentoId
     *
     * @return self
     */
    public function setMagentoId(string $magentoId);

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     *
     * @return mixed
     */
    public function setStatus(string $status);

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message);

    /**
     * @return null|string
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
}
