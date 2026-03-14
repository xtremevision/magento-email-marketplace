<?php

namespace Zitec\EmagMarketplace\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Zitec\EmagMarketplace\Api\AwbRepositoryInterface;
use Zitec\EmagMarketplace\Model\ResourceModel\Awb as ResourceModel;

/**
 * Class AwbRepository
 * @package Zitec\EmagMarketplace\Model
 */
class AwbRepository implements AwbRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * @var AwbFactory
     */
    protected $factory;

    /**
     * AwbRepository constructor.
     *
     * @param ResourceModel $resourceModel
     * @param AwbFactory $factory
     */
    public function __construct(ResourceModel $resourceModel, AwbFactory $factory)
    {
        $this->resourceModel = $resourceModel;
        $this->factory       = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Awb $awb)
    {
        $this->resourceModel->save($awb);
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): Awb
    {
        /** @var Awb $object */
        $object = $this->factory->create();

        $this->resourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('AWB with id "%1" does not exist.', $id));
        }

        return $object;
    }
}
