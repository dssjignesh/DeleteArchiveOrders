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

use Dss\ArchiveOrders\Api\Data\ArchiveInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

interface ArchiveRepositoryInterface
{
    /**
     * Save
     *
     * @param ArchiveInterface $archiveModel
     * @return ArchiveInterface
     * @throws CouldNotSaveException
     */
    public function save(ArchiveInterface $archiveModel): ArchiveInterface;

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return ArchiveInterface
     * @throws NoSuchEntityException
     */
    public function get($entityId): ArchiveInterface;

    /**
     * Delete
     *
     * @param ArchiveInterface $archiveModel
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ArchiveInterface $archiveModel): bool;

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($entityId): bool;
}
