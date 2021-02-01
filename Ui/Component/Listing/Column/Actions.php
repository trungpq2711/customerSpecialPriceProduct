<?php

namespace Extensions\CustomerSpecialPrice\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /** Url path */
    const CUSTOMER_SPECIAL_URL_PATH_DELETE = 'customer_special_price/customer_special/delete';
    const CUSTOMER_SPECIAL_URL_PATH_EDIT = 'customer_special_price/customer_special/edit';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                $item[$name]['delete'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::CUSTOMER_SPECIAL_URL_PATH_DELETE,
                        ['entity_id' => $item['entity_id']]
                    ),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete'),
                        'message' => __('Are you sure you want to delete customer special price with id: %1?', $item['entity_id'])
                    ],
                    'post' => true
                ];
                $item[$name]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        self::CUSTOMER_SPECIAL_URL_PATH_EDIT,
                        ['entity_id' => $item['entity_id']]
                    ),
                    'label' => __('View/Edit'),
                ];
            }
        }

        return $dataSource;
    }
}
