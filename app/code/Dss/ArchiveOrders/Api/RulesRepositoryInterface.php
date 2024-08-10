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
namespace Dss\ArchiveOrders\Api;

use Dss\ArchiveOrders\Api\Data\RulesInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

interface RulesRepositoryInterface
{
    /**
     * Save
     *
     * @param RulesInterface $rulesModel
     * @return RulesInterface
     * @throws CouldNotSaveException
     */
    public function save(RulesInterface $rulesModel): RulesInterface;

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return RulesInterface
     * @throws NoSuchEntityException
     */
    public function get($entityId): RulesInterface;

    /**
     * Delete
     *
     * @param RulesInterface $rulesModel
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(RulesInterface $rulesModel): bool;

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($entityId): bool;
}
