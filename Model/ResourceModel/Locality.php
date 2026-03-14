<?php

namespace Zitec\EmagMarketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Locality
 * @package Zitec\EmagMarketplace\Model\ResourceModel
 */
class Locality extends AbstractDb
{
    /**
     * @var
     */
    protected $connection;

    /**
     * 
     */
    protected function _construct()
    {
        $this->_init('zitec_emkp_localities', 'id');
        $this->connection = $this->getConnection();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function massInsert(array $data): int
    {
        return $this->connection->insertMultiple($this->getMainTable(), $data);
    }

    /**
     * @return mixed
     */
    public function emptyTable()
    {
        $select = $this->connection->select();
        $select->from(
            [$this->getMainTable()]
        );

        $this->connection->deleteFromSelect(
            $select,
            $this->getMainTable()
        );

        return $this->connection->query($this->connection->deleteFromSelect(
            $select,
            $this->getMainTable()
        ));
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public function updateLocalitiesData(array $data)
    {
        try {
            $this->connection->beginTransaction();

            $this->emptyTable();
            $this->massInsert($data);

            $this->connection->commit();

        } catch (\Exception $e) {
            $this->getConnection()->rollBack();

            throw $e;
        }
    }
}
