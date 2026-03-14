<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface CategoryMappingInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface CategoryMappingInterface
{
    const ID = 'id';
    const EMAG_CATEGORY_ID = 'emag_category_id';
    const MAGENTO_CATEGORY_ID = 'magento_category_id';

    const TABLE = 'zitec_emkp_category_mapping';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return self
     */
    public function setEmagCategoryId(int $id);

    /**
     * @return int
     */
    public function getEmagCategoryId(): int;

    /**
     * @param int $id
     * @return self
     */
    public function setMagentoCategoryId(int $id);

    /**
     * @return int
     */
    public function getMagentoCategoryId(): int;
}
