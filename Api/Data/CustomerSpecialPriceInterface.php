<?php

namespace Extensions\CustomerSpecialPrice\Api\Data;

/**
 * Interface CustomerSpecialPriceInterface
 * @package Extensions\CustomerSpecialPrice\Api\Data
 */
interface CustomerSpecialPriceInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ENTITY_ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const IS_ACTIVE = 'is_active';
    const PRIORITY = 'priority';
    /**#@-*/

    /**
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId(int $customerId);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param string $fromDate
     *
     * @return $this
     */
    public function setFromDate(string $fromDate);

    /**
     * @return string
     */
    public function getFromDate();

    /**
     * @param string $toDate
     *
     * @return $this
     */
    public function setToDate(string $toDate);

    /**
     * @return string
     */
    public function getToDate();

    /**
     * @param int $isActive
     *
     * @return $this
     */
    public function setIsActive(int $isActive);

    /**
     * @return int
     */
    public function getIsActive();

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority(int $priority);

    /**
     * @return int
     */
    public function getPriority();
}
