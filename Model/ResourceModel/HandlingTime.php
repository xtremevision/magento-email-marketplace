<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class HandlingTime
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class HandlingTime extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('zitec_emkp_handling_time', 'id');
    }
}
