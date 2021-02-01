<?php

namespace Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;

use Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Edit
 * @package Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special
 */
class Edit extends Special implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->_objectManager->create(\Extensions\CustomerSpecialPrice\Model\CustomerSpecialPrice::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This customer special price no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('customer_special_price', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Customer Special Price') : __('New Customer Special Price'),
            $id ? __('Edit Customer Special Price') : __('New Customer Special Price')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Special Price'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Customer Special Price'));
        return $resultPage;
    }
}
