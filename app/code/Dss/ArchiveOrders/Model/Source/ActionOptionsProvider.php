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

class ActionOptionsProvider implements OptionSourceInterface
{
    public const ACTION_ARCHIVE = 1;
    public const ACTION_DELETE = 0;

    /**
     * Get options
     *
     * @return array
     */
    public function getOptionArray(): array
    {
        return [
            self::ACTION_ARCHIVE => __('Archive'),
            self::ACTION_DELETE => __('Delete')
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
