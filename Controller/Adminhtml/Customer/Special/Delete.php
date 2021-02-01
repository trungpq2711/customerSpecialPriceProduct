<?php

namespace Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;

use Extensions\CustomerSpecialPrice\Api\CustomerSpecialPriceRepositoryInterface;
use Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Delete extends Special implements HttpPostActionInterface
{
    /**
     * @var CustomerSpecialPriceRepositoryInterface
     */
    private $customerSpecialPriceRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param CustomerSpecialPriceRepositoryInterface|null $customerSpecialPriceRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        CustomerSpecialPriceRepositoryInterface $customerSpecialPriceRepository = null
    ) {
        $this->customerSpecialPriceRepository = $customerSpecialPriceRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(CustomerSpecialPriceRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }
    /**
     * @return void
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                $this->customerSpecialPriceRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the customer special price.'));
                $this->_redirect('customer_special_price/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete this customer special price right now. Please review the log and try again.')
                );
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
                $this->_redirect('customer_special_price/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
                return;
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a customer special price to delete.'));
        $this->_redirect('customer_special_price/*/');
    }
}
