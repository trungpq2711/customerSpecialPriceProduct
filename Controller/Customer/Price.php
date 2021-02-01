<?php

namespace Extensions\CustomerSpecialPrice\Controller\Customer;

use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProductFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Price
 * @package Extensions\CustomerSpecialPrice\Controller\Customer
 */
class Price extends Action implements HttpPostActionInterface
{
    /**
     * @var CustomerSpecialPriceProductFactory
     */
    protected $customerSpecialPriceProductFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Price constructor.
     *
     * @param Context $context
     * @param CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory
     * @param Session $customerSession
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory,
        Session $customerSession,
        LoggerInterface $logger
    ) {
        $this->customerSpecialPriceProductFactory = $customerSpecialPriceProductFactory;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $productIds = $this->getRequest()->getParam('productIds');
        $customerId = $this->customerSession->getCustomer()->getId();
        $data = [];
        try {
            $data = $this->customerSpecialPriceProductFactory->create()->getPriceProducts((int)$customerId, $productIds);
        } catch (\Exception $e) {
            $this->logger->error($e);
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $resultJson->setData($data);
    }
}
