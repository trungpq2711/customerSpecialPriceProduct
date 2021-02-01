<?php

namespace Extensions\CustomerSpecialPrice\Model\CustomerSpecialPrice;

use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice\Collection;
use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice\CollectionFactory;
use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProductFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var CustomerSpecialPriceProductFactory
     */
    protected $customerSpecialPriceProductFactory;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->customerSpecialPriceProductFactory = $customerSpecialPriceProductFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Extensions\CustomerSpecialPrice\Model\CustomerSpecialPrice $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $this->loadedData[$item->getId()]['products'] =
                $this->customerSpecialPriceProductFactory->getProductsById($item->getId());
        }

        $data = $this->dataPersistor->get('customer_special_price');

        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getId()] = $item->getData();
            $this->dataPersistor->clear('customer_special_price');
        }

        return $this->loadedData;
    }
}
