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

class ScopeOptionsProvider implements OptionSourceInterface
{
    public const SALES_GRID_SCOPE = 1;
    public const ARCHIVE_GRID_SCOPE = 0;

    /**
     * Get status options
     *
     * @return array
     */
    public function getOptionArray(): array
    {
        return [
            self::SALES_GRID_SCOPE => __('Sales Order Grid'),
            self::ARCHIVE_GRID_SCOPE => __('Archive Order Grid')
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
