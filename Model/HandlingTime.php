<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Model\AbstractModel;
use Zitec\EmagMarketplace\Api\Data\HandlingTimeInterface;

/**
 * Class HandlingTime
 * @package Zitec\EmagMarketplace\Model
 */
class HandlingTime extends AbstractModel implements HandlingTimeInterface
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Zitec\EmagMarketplace\Model\ResourceModel\HandlingTime');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getHandlingTime(): float
    {
        return $this->getData(self::HANDLING_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function setHandlingTime(float $handlingTime)
    {
        return $this->setData(self::HANDLING_TIME, $handlingTime);
    }
}
