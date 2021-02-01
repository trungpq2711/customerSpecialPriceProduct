<?php

namespace Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;

use Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Class NewAction
 * @package Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special
 */
class NewAction extends Special implements HttpGetActionInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
