<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\HandlingTime;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\HandlingTime
 */
class ReadRequest extends AbstractRequest
{
    protected $endpoint = 'handling_time/read';
}
