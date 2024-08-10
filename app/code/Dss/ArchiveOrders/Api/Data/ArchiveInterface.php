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
namespace Dss\ArchiveOrders\Api\Data;

interface ArchiveInterface
{
    public const RECORD_ID = 'record_id';
    public const ORDER_ID = 'order_id';
    public const ARCHIVED_AT = 'archived_at';

    /**
     * Returns record_id field
     *
     * @return int
     */
    public function getRecordId(): int;

    /**
     * Set record_id
     *
     * @param int $record_id
     * @return $this
     */
    public function setRecordId($record_id): self;

    /**
     * Returns orderId field
     *
     * @return int
     */
    public function getOrderId(): int;

    /**
     * Set order_id
     *
     * @param int $order_id
     * @return $this
     */
    public function setOrderId($order_id): self;

    /**
     * Returns archived_at field
     *
     * @return string
     */
    public function getArchivedAt(): string;

    /**
     * Set archived_at
     *
     * @param string $date
     * @return $this
     */
    public function setArchivedAt($date): self;
}
