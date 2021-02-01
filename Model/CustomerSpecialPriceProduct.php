<?php

namespace Extensions\CustomerSpecialPrice\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class CustomerSpecialPriceProduct
 * @package Extensions\CustomerSpecialPrice\Model
 */
class CustomerSpecialPriceProduct extends AbstractModel
{
    /**
     * Initialize CustomerSpecialPriceProduct model
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\CustomerSpecialPriceProduct::class);
    }
}
