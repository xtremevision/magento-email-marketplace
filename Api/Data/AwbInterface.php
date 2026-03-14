<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface AwbInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface AwbInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const ORDER_ID = 'order_id';
    const COURIER_NAME = 'courier_name';
    const AWB_NUMBER = 'awb_number';
    const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return self
     */
    public function setEmagId(int $id);

    /**
     * @return int|null
     */
    public function getEmagId();

    /**
     * @param int $id
     *
     * @return self
     */
    public function setOrderId(int $id);

    /**
     * @return int|null
     */
    public function getOrderId();

    /**
     * @param string $name
     *
     * @return self
     */
    public function setCourierName(string $name);

    /**
     * @return null|string
     */
    public function getCourierName();

    /**
     * @param string $number
     *
     * @return self
     */
    public function setAwbNumber(string $number);

    /**
     * @return null|string
     */
    public function getAwbNumber();

    /**
     * @return null|string
     */
    public function getCreatedAt();
}
