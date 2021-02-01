<?php

namespace Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice;

use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice as ResourceModel;
use Extensions\CustomerSpecialPrice\Model\CustomerSpecialPrice as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPrice
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
