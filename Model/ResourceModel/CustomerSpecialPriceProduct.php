<?php

namespace Extensions\CustomerSpecialPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class CustomerSpecialPriceProduct
 * @package Extensions\CustomerSpecialPrice\Model\ResourceModel
 */
class CustomerSpecialPriceProduct extends AbstractDb
{
    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * CustomerProductPrice constructor.
     *
     * @param Context $context
     * @param DateTime $dateTime
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        $connectionName = null
    ) {
        $this->dateTime = $dateTime;
        parent::__construct($context, $connectionName);
    }
    /**
     * Initialize main table and table id field
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init('customer_special_price_product', 'entity_id');
    }

    /**
     * @param array $data
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function insertOnDuplicate(array $data) : void
    {
        $table = $this->getMainTable();
        $this->getConnection()->insertOnDuplicate($table, $data, ['price']);
    }

    /**
     * @param int $id
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteSpecialProductByCustomerId(int $id) : void
    {
        $table = $this->getMainTable();
        $this->getConnection()->delete($table, ['customer_special_price_id = ?' => $id]);
    }

    /**
     * @param int $id
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductsById(int $id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['product_id', 'price'])
            ->where('customer_special_price_id = ?', $id);

        return $this->getConnection()->fetchAll($select);
    }

    /**
     * @param int $customerId
     * @param array $productIds
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPriceProducts(int $customerId, $productIds = [])
    {
        $currentTimeStamp = $this->dateTime->timestamp();
        $now = date('Y-m-d H:i:s', $currentTimeStamp);
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['product_id', 'price'])
            ->where('is_active = ?', 1)
            ->where('product_id in (?)', $productIds)
            ->where('customer_id = ?', $customerId)
            ->where('from_date <= ? OR from_date IS NULL', $now)
            ->where('to_date >= ? OR to_date IS NULL', $now)
            ->order('priority');

        return $this->getConnection()->fetchAll($select);
    }

    /**
     * @param int $customerId
     * @param int $productId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPriceProduct(int $customerId, int $productId)
    {
        $currentTimeStamp = $this->dateTime->timestamp();
        $now = date('Y-m-d H:i:s', $currentTimeStamp);
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['price'])
            ->where('is_active = ?', 1)
            ->where('product_id = (?)', $productId)
            ->where('customer_id = ?', $customerId)
            ->where('from_date <= ? OR from_date IS NULL', $now)
            ->where('to_date >= ? OR to_date IS NULL', $now)
            ->order('priority');

        return $this->getConnection()->fetchOne($select);
    }
}
