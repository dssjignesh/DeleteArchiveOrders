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
namespace Dss\ArchiveOrders\Model\ResourceModel\Archive;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dss\ArchiveOrders\Model\Archive;
use Dss\ArchiveOrders\Model\ResourceModel\Archive as ResourceModelArchive;

class Collection extends AbstractCollection
{
    /**
     * Main table primary key field name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Archive::class,
            ResourceModelArchive::class
        );
    }
}
