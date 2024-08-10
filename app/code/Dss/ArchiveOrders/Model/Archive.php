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
namespace Dss\ArchiveOrders\Model;

use Dss\ArchiveOrders\Api\Data\ArchiveInterface;
use Magento\Framework\Model\AbstractModel;
use Dss\ArchiveOrders\Model\ResourceModel\Archive as ResourceModelArchive;

class Archive extends AbstractModel implements ArchiveInterface
{
    /**
     * Class constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModelArchive::class);
        $this->setIdFieldName('record_id');
    }

    /**
     * Get record id
     *
     * @return int recordId
     */
    public function getRecordId(): int
    {
        return $this->getData(self::RECORD_ID);
    }

    /**
     * Set record id
     *
     * @param int $recordId
     * @return $this
     */
    public function setRecordId($recordId): self
    {
        return $this->setData(self::RECORD_ID, $recordId);
    }

    /**
     * Get order id
     *
     * @return int orderId
     */
    public function getOrderId(): int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set order id
     *
     * @param int $orderId
     * @return $this
     */
    public function setOrderId($orderId): self
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get archived at
     *
     * @return string archived_at
     */
    public function getArchivedAt(): string
    {
        return $this->getData(self::ARCHIVED_AT);
    }

    /**
     * Set archived at
     *
     * @param string $date
     * @return $this
     */
    public function setArchivedAt($date): self
    {
        return $this->setData(self::ARCHIVED_AT, $date);
    }
}
