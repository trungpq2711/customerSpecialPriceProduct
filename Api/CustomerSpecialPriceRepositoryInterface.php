<?php

namespace Extensions\CustomerSpecialPrice\Api;

/**
 * Interface CustomerSpecialPriceRepositoryInterface
 * @package Extensions\CustomerSpecialPrice\Api
 */
interface CustomerSpecialPriceRepositoryInterface
{
    /**
     * Save CustomerSpecialPrice.
     *
     * @param \Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface $customerSpecialPrice
     * @return \Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface $customerSpecialPrice);

    /**
     * @param int $entityId
     * @return mixed
     */
    public function getById(int $entityId);

    /**
     * Delete CustomerSpecialPrice.
     *
     * @param \Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface $customerSpecialPrice
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface $customerSpecialPrice);

    /**
     * Delete CustomerSpecialPrice by ID.
     *
     * @param string $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($entityId);
}
