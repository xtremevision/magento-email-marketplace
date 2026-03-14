<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Locality;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class CountRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Locality
 */
class CountRequest extends AbstractRequest
{
    protected $endpoint = 'locality/count';
}
