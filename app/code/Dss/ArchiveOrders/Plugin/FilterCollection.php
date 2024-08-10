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
namespace Dss\ArchiveOrders\Plugin;

use Dss\ArchiveOrders\Model\ResourceModel\Archive\Grid\Collection as ArchiveCollection;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderCollection;
use Dss\ArchiveOrders\Model\ResourceModel\Archive as ArchiveModel;

class FilterCollection
{
    /**
     * After search method
     *
     * @param array $subject
     * @param array $collection
     * @return ArchiveCollection|OrderCollection|mixed
     */
    public function afterSearch($subject, $collection)
    {
        if ($collection instanceof ArchiveCollection) {
            $collection->joinSalesOrdeGridTable();
            $collection->clear()->load();
        } elseif ($collection instanceof OrderCollection) {
            $collection->getSelect()->joinLeft(
                ['archive_table' => $collection->getTable(ArchiveModel::TABLE_NAME)],
                'main_table.entity_id = archive_table.order_id',
                ['order_id']
            );
            $collection->addFieldToFilter('archive_table.order_id', ['null' => true]);
            $collection->clear()->load();
        }

        return $collection;
    }
}
