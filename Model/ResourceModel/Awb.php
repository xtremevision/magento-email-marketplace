<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Zitec\EmagMarketplace\Api\Data\AwbInterface;

/**
 * Class Awb
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class Awb extends AbstractDb
{
    protected $_idFieldName = AwbInterface::ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init('zitec_emkp_awbs', AwbInterface::ID);
    }
}
