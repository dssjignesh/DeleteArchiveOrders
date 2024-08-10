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

interface RulesInterface
{
    public const ENTITY_ID = 'entity_id';
    public const TITLE = 'title';
    public const SCOPE = 'scope';
    public const ORDER_STATUSES = 'order_statuses';
    public const ACTION = 'action';
    public const TIME = 'time';
    public const IS_ACTIVE = 'is_active';

    /**
     * Returns entity_id field
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Set entity_id
     *
     * @param int $entity_id
     * @return $this
     */
    public function setEntityId($entity_id): self;

    /**
     * Returns title field
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title): self;

    /**
     * Returns scope field
     *
     * @return int
     */
    public function getScope(): int;

    /**
     * Set scope
     *
     * @param int $scope
     * @return $this
     */
    public function setScope($scope): self;

    /**
     * Returns order_statuses field
     *
     * @return string
     */
    public function getOrderStatues(): string;

    /**
     * Set statuses
     *
     * @param string $statuses
     * @return $this
     */
    public function setOrderStatues($statuses): self;

    /**
     * Returns action field
     *
     * @return int
     */
    public function getAction(): int;

    /**
     * Set action
     *
     * @param int $action
     * @return $this
     */
    public function setAction($action): self;

    /**
     * Returns time field
     *
     * @return int
     */
    public function getTime(): int;

    /**
     * Set time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time): self;

    /**
     * Returns action field
     *
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * Set is_active
     *
     * @param bool $is_active
     * @return $this
     */
    public function setIsActive($is_active): self;
}
