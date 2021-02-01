<?php

namespace Extensions\CustomerSpecialPrice\Observer;

use Extensions\CustomerSpecialPrice\Model\ResourceModel\CustomerSpecialPriceProductFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CustomerSpecialPrice
 * @package Extensions\CustomerSpecialPrice\Observer
 */
class CustomerSpecialPrice implements ObserverInterface
{
    /**
     * @var CustomerSpecialPriceProductFactory
     */
    private $customerSpecialPriceProductFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CustomerPriceInCart constructor.
     *
     * @param CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CustomerSpecialPriceProductFactory $customerSpecialPriceProductFactory,
        LoggerInterface $logger
    ) {
        $this->customerSpecialPriceProductFactory = $customerSpecialPriceProductFactory;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $customerId = $item->getQuote()->getCustomerId();
        if ($customerId) {
            $productId[] = $item->getProductId();
            try {
                $price = $this->customerSpecialPriceProductFactory->create()->getPriceProducts(
                    $customerId,
                    $productId
                );
                if ($price) {
                    $item->setCustomPrice($price);
                    $item->setOriginalCustomPrice($price);
                    $item->getProduct()->setIsSuperMode(true);
                }
            } catch (\Exception $e) {
                $this->logger->error($e);
            }
        }
    }
}
