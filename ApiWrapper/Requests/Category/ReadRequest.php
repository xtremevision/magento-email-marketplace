<?php

namespace Zitec\EmagMarketplace\ApiWrapper\Requests\Category;

use Zitec\EmagMarketplace\ApiWrapper\Requests\AbstractRequest;

/**
 * Class ReadRequest
 * @package Zitec\EmagMarketplace\ApiWrapper\Requests\Category
 */
class ReadRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'category/read';
}
