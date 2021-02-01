<?php

namespace Extensions\CustomerSpecialPrice\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Product
 * @package Extensions\CustomerSpecialPrice\Model\Config\Source
 */
class Product implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Customer constructor.
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (empty($this->options)) {
            $this->options[] = [
                'label' => __('Please select product'),
                'value' => '',
            ];
            $collection = $this->collectionFactory->create();
            foreach ($collection->getItems() as $product) {
                $this->options[] = [
                    'label' => $product->getSku(),
                    'value' => $product->getId(),
                ];
            }
        }

        return $this->options;
    }
}
