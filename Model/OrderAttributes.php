<?php

namespace Zitec\EmagMarketplace\Model;

/**
 * Class OrderAttributes
 * @package Zitec\EmagMarketplace\Model
 */
class OrderAttributes
{
    const IS_EMAG_ORDER = 'emkp_is_emag_order';
    const EMAG_ORDER_DATA = 'emkp_emag_order_data';
    const EMAG_ORDER_ID = 'emkp_emag_order_id';
    const EMAG_PAYMENT_COD_ID = 1;
    const EMAG_PAYMENT_BANK_TRANSFER_ID = 2;
    const EMAG_PAYMENT_ONLINE_CARD_PAYMENT_ID = 3;
}
