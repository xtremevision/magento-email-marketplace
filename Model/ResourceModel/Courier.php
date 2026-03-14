<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Courier
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class Courier extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('zitec_emkp_couriers', 'id');
    }
}
