<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface CharacteristicMappingInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface CharacteristicMappingInterface
{
    const ID = 'id';
    const MAPPING_ID = 'mapping_id';
    const EMAG_CHARACTERISTIC_ID = 'emag_characteristic_id';
    const MAGENTO_ATTRIBUTE_ID = 'magento_attribute_id';

    const TABLE = 'zitec_emkp_characteristic_mapping';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return self
     */
    public function setMappingId(int $id);

    /**
     * @return int
     */
    public function getMappingId(): int;

    /**
     * @param int $id
     * @return self
     */
    public function setEmagCharacteristicId(int $id);

    /**
     * @return int
     */
    public function getEmagCharacteristicId(): int;

    /**
     * @param int $id
     * @return self
     */
    public function setMagentoAttributeId(int $id);

    /**
     * @return int
     */
    public function getMagentoAttributeId(): int;
}
