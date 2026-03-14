<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\CourierAccount;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\CourierAccount
 */
class ReadRequest extends AbstractRequest
{
    protected $endpoint = 'courier_accounts/read';
}
