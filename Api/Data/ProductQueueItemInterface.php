<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface ProductQueueItemInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface ProductQueueItemInterface
{
    const ID = 'id';
    const PRODUCT_ID = 'product_id';
    const ACTION = 'action';
    const STATE = 'state';
    const RESPONSE = 'response';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    const STATE_PENDING = 'pending';
    const STATE_IN_PROGRESS = 'in-progress';
    const STATE_COMPLETE = 'complete';
    const STATE_FAILED = 'failed';
    const STATE_CANCELLED = 'cancelled';

    const TABLE = 'zitec_emkp_queue_products';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return self
     */
    public function setProductId(int $id);

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param string $action
     * @return self
     */
    public function setAction(string $action);

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @param string $state
     * @return self
     */
    public function setState(string $state);

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param null|string $response
     * @return self
     */
    public function setResponse($response = null);

    /**
     * @return null|string
     */
    public function getResponse();

    /**
     * @return null|string
     */
    public function getCreatedAt(): string;

    /**
     * @return null|string
     */
    public function getUpdatedAt(): string;
}
