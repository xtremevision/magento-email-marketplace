<?php

namespace Zitec\EmagMarketplace\Api\Data;

/**
 * Interface CharacteristicInterface
 * @package Zitec\EmagMarketplace\Api\Data
 */
interface CharacteristicInterface
{
    const ID = 'id';
    const EMAG_ID = 'emag_id';
    const NAME = 'name';
    const CATEGORY_EMAG_ID = 'category_emag_id';
    const IS_MANDATORY = 'is_mandatory';
    const ALLOW_NEW_VALUE = 'allow_new_value';
    const VALUES = 'values';

    const TABLE = 'zitec_emkp_characteristics';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return self
     */
    public function setEmagId(int $id);

    /**
     * @return int
     */
    public function getEmagId(): int;

    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string|null $values
     * @return self
     */
    public function setValues($values = null);

    /**
     * @return null|string
     */
    public function getValues();

    /**
     * @param bool $allowNewValue
     * @return mixed
     */
    public function setAllowNewValue(bool $allowNewValue);

    /**
     * @return bool
     */
    public function getAllowNewValue(): bool;

    /**
     * @param int $id
     * @return self
     */
    public function setCategoryEmagId(int $id);

    /**
     * @return int
     */
    public function getCategoryEmagId(): int;

    /**
     * @param bool $isMandatory
     * @return self
     */
    public function setIsMandatory(bool $isMandatory);

    /**
     * @return bool
     */
    public function isMandatory(): bool;
}
