<?php

namespace Extensions\CustomerSpecialPrice\Model;

use Extensions\CustomerSpecialPrice\Api\CustomerSpecialPriceRepositoryInterface;
use Extensions\CustomerSpecialPrice\Api\Data\CustomerSpecialPriceInterface;
use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice as ResourceCustomerSpecialPrice;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomerSpecialPriceRepository implements CustomerSpecialPriceRepositoryInterface
{
    /**
     * @var ResourceCustomerSpecialPrice
     */
    protected $resource;

    /**
     * @var CustomerSpecialPriceFactory
     */
    protected $customerSpecialPriceFactory;

    /**
     * cache data by id
     * @var array
     */
    protected $customerSpecialPrice = [];

    /**
     * CustomerSpecialPriceRepository constructor.
     * @param ResourceCustomerSpecialPrice $resource
     * @param CustomerSpecialPriceFactory $customerSpecialPriceFactory
     */
    public function __construct(
        ResourceCustomerSpecialPrice $resource,
        CustomerSpecialPriceFactory $customerSpecialPriceFactory
    ) {
        $this->resource = $resource;
        $this->customerSpecialPriceFactory = $customerSpecialPriceFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(CustomerSpecialPriceInterface $customerSpecialPrice)
    {
        try {
            $this->resource->save($customerSpecialPrice);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $customerSpecialPrice;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId)
    {
        if (!isset($this->customerSpecialPrice[$entityId])) {
            $customerSpecialPrice = $this->customerSpecialPriceFactory->create();
            $this->resource->load($customerSpecialPrice, $entityId);
            if (!$customerSpecialPrice->getId()) {
                throw new NoSuchEntityException(__('The customer special price with the "%1" ID doesn\'t exist.', $entityId));
            }
            $this->customerSpecialPrice[$entityId] = $customerSpecialPrice;
        }
        return $this->customerSpecialPrice[$entityId];
    }

    /**
     * @inheritDoc
     */
    public function delete(CustomerSpecialPriceInterface $customerSpecialPrice)
    {
        try {
            $this->resource->delete($customerSpecialPrice);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }
}
