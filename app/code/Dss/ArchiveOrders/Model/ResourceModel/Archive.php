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
namespace Dss\ArchiveOrders\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Archive extends AbstractDb
{
    public const TABLE_NAME = 'dss_archiveorders_order_archive';
    public const ID_FIELD_NAME = 'record_id';

    /**
     *  Class constructor
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
