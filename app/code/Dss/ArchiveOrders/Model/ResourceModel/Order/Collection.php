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
namespace Dss\ArchiveOrders\Model\ResourceModel\Order;

use Magento\Sales\Model\ResourceModel\Order\Collection as OrderCollection;
use Dss\ArchiveOrders\Model\ResourceModel\Archive;

class Collection extends OrderCollection
{
    /**
     * Add archive table to collection
     *
     * @param string[] $fieldsToSelect
     * @param bool $isArchived
     * @return $this
     */
    public function joinArchiveTable($fieldsToSelect = ['order_id'], $isArchived = false)
    {
        $this->getSelect()->joinLeft(
            ['archive_table' => $this->getTable(Archive::TABLE_NAME)],
            'main_table.entity_id = archive_table.order_id',
            $fieldsToSelect
        );
        $this->addFieldToFilter('archive_table.order_id', [$isArchived ? 'notnull' : 'null' => true]);
        return $this;
    }
}
