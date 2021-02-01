<?php

namespace Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;

use Extensions\CustomerSpecialPrice\Api\CustomerSpecialPriceRepositoryInterface;
use Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special;
use Extensions\CustomerSpecialPrice\Model\CustomerSpecialPrice;
use Extensions\CustomerSpecialPrice\Model\CustomerSpecialPriceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Class Save
 * @package Extensions\CustomerSpecialPrice\Controller\Adminhtml\Customer\Special
 */
class Save extends Special implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var CustomerSpecialPriceFactory
     */
    private $customerSpecialPriceFactory;

    /**
     * @var CustomerSpecialPriceRepositoryInterface
     */
    private $customerSpecialPriceRepository;

    /**
     * @var CustomerSpecialPriceProductFactory|mixed|null
     */
    private $customerSpecialPriceProductFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param CustomerSpecialPriceFactory|null $customerSpecialPriceFactory
     * @param CustomerSpecialPriceRepositoryInterface|null $customerSpecialPriceRepository
     * @param CustomerSpecialPriceProductFactory|null $customerSpecialPriceProductFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        CustomerSpecialPriceFactory $customerSpecialPriceFactory = null,
        CustomerSpecialPriceRepositoryInterface $customerSpecialPriceRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->customerSpecialPriceFactory = $customerSpecialPriceFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(CustomerSpecialPriceFactory::class);
        $this->customerSpecialPriceRepository = $customerSpecialPriceRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(CustomerSpecialPriceRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            /** @var CustomerSpecialPrice $model */
            $model = $this->customerSpecialPriceFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->customerSpecialPriceRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This customer special price no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }
            $model->setData($data);

            try {
                $this->customerSpecialPriceRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the customer special price.'));
                $this->dataPersistor->clear('customer_special_price');
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('customer_special_price/*/edit', ['entity_id' => $model->getId()]);
                    $resultRedirect->setPath('*/*/edit', ['block_id' => $model->getId()]);
                }
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the customer special price.'));
            }

            $this->dataPersistor->set('customer_special_price', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
