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

use Dss\ArchiveOrders\Api\Data\RulesInterface;
use Magento\Framework\Model\AbstractModel;
use Dss\ArchiveOrders\Model\ResourceModel\Rules as ResourceModelRules;

class Rules extends AbstractModel implements RulesInterface
{
    /**
     * Class constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModelRules::class);
        $this->setIdFieldName('entity_id');
    }

    /**
     * Get entity id
     *
     * @return int entityId
     */
    public function getEntityId(): int
    {
        return (int) $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId): self
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get title
     *
     * @return string title
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title): self
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get scope
     *
     * @return int scope
     */
    public function getScope(): int
    {
        return $this->getData(self::SCOPE);
    }

    /**
     * Set scope
     *
     * @param int $scope
     * @return $this
     */
    public function setScope($scope): self
    {
        return $this->setData(self::SCOPE, $scope);
    }

    /**
     * Get order statuses
     *
     * @return string statuses
     */
    public function getOrderStatues(): string
    {
        return $this->getData(self::ORDER_STATUSES);
    }

    /**
     * Set order statuses
     *
     * @param string $statuses
     * @return $this
     */
    public function setOrderStatues($statuses): self
    {
        return $this->setData(self::ORDER_STATUSES, $statuses);
    }

    /**
     * Get action
     *
     * @return int action
     */
    public function getAction(): int
    {
        return $this->getData(self::ACTION);
    }

    /**
     * Set action
     *
     * @param int $action
     * @return $this
     */
    public function setAction($action): self
    {
        return $this->setData(self::ACTION, $action);
    }

    /**
     * Get time
     *
     * @return int time
     */
    public function getTime(): int
    {
        return $this->getData(self::TIME);
    }

    /**
     * Set time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time): self
    {
        return $this->setData(self::TIME, $time);
    }

    /**
     * Get is active
     *
     * @return bool is_active
     */
    public function getIsActive(): bool
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is active
     *
     * @param bool $is_active
     * @return $this
     */
    public function setIsActive($is_active): self
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
}
