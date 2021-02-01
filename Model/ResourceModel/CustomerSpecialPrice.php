<?php

namespace Extensions\CustomerSpecialPrice\Model\ResourceModel;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class CustomerSpecialPrice
 * @package Extensions\CustomerSpecialPrice\Model\ResourceModel
 */
class CustomerSpecialPrice extends AbstractDb
{
    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Initialize main table and table id field
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init('customer_special_price', $this->_idFieldName);
    }

    /**
     * Perform actions after entity save
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @since 100.1.0
     */
    public function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $products = $object->getData('products');
        $dataProducts = [];
        $id = $object->getId();
        foreach ($products as $product) {
            $dataProducts[] = [
                'customer_special_price_id' => $id,
                'product_id' => $product['product_id'],
                'price' => $product['price'],
                'customer_id' => $object->getData('customer_id'),
                'from_date' => $object->getData('from_date'),
                'to_date' => $object->getData('to_date'),
                'is_active' => $object->getData('is_active'),
                'priority' => $object->getData('priority'),
            ];
        }

        if (!empty($dataProducts)) {
            $productPriceResource = ObjectManager::getInstance()->get(CustomerSpecialPriceProductFactory::class)->create();
            $productPriceResource->deleteSpecialProductByCustomerId($id);
            $productPriceResource->insertOnDuplicate($dataProducts);
        }

        return $this;
    }
}
