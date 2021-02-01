<?php

namespace Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProduct;

use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProduct as ResourceModel;
use Extensions\CustomerSpecialPrice\Model\CustomerSpecialPriceProduct as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProduct
 */
class Collection extends AbstractCollection
{
    /**
    * Set resource model
    *
    * @return void
    * @codeCoverageIgnore
    */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
