<?php

namespace Extensions\CustomerSpecialPrice\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 * @package Extensions\CustomerSpecialPrice\Model\Config\Source
 */
class IsActive implements OptionSourceInterface
{
    const STATUS_DISABLED = 0;

    const STATUS_ENABLED = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Enabled'),
                'value' => self::STATUS_ENABLED,
            ],
            [
                'label' => __('Disabled'),
                'value' => self::STATUS_DISABLED,
            ]
        ];
    }
}
