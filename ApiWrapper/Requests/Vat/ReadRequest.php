<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Vat;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Vat
 */
class ReadRequest extends AbstractRequest
{
    protected $endpoint = 'vat/read';
}
