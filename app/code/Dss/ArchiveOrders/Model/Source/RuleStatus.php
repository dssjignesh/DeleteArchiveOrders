<?php

declare(strict_types=1);
/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_ArchiveOrders
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
namespace Dss\ArchiveOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class RuleStatus implements OptionSourceInterface
{
    public const RULE_STATUS_ENABLE = 1;
    public const RULE_STATUS_DISABLE = 0;

    /**
     * Get status options
     *
     * @return array
     */
    public function getOptionArray(): array
    {
        return [
            self::RULE_STATUS_ENABLE => __('Enabled'),
            self::RULE_STATUS_DISABLE => __('Disabled')
        ];
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach (self::getOptionArray() as $index => $value) {
            $options[] = ['value' => $index, 'label' => $value];
        }
        return $options;
    }
}
