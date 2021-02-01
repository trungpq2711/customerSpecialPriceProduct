<?php

namespace Extensions\CustomerSpecialPrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Locale\FormatInterface as LocaleFormat;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    const CUSTOMER_SPECIAL_PRICE_ACTIVE = 'customer_special_price/special_price/active';
    const CUSTOMER_SPECIAL_PRICE_LABEL = 'customer_special_price/special_price/label';

    /**
     * @var LocaleFormat
     */
    protected $localeFormat;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Json
     */
    protected $json;

    /**
     * Data constructor.
     * @param Context $context
     * @param LocaleFormat $localeFormat
     * @param StoreManagerInterface $storeManager
     * @param Json $json
     */
    public function __construct(
        Context $context,
        LocaleFormat $localeFormat,
        StoreManagerInterface $storeManager,
        Json $json
    ) {
        $this->localeFormat = $localeFormat;
        $this->_storeManager = $storeManager;
        $this->json = $json;
        parent::__construct($context);
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFormatPrice()
    {
        $currencyCode = $this->_storeManager->getStore()->getCurrentCurrencyCode();
        return $this->json->serialize($this->localeFormat->getPriceFormat(null, $currencyCode));
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function isEnabled($storeId = null)
    {
        return (int)$this->scopeConfig->getValue(self::CUSTOMER_SPECIAL_PRICE_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getLabel($storeId = null)
    {
        return $this->scopeConfig->getValue(self::CUSTOMER_SPECIAL_PRICE_LABEL, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
