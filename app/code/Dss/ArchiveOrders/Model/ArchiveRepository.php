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

use Dss\ArchiveOrders\Api\ArchiveRepositoryInterface;
use Dss\ArchiveOrders\Api\Data;
use Dss\ArchiveOrders\Model\ResourceModel\Archive;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Dss\ArchiveOrders\Model\Archive as ModelArchive;

class ArchiveRepository implements ArchiveRepositoryInterface
{
    /**
     * ArchiveRepository constructor.
     *
     * @param Archive $archiveModelResource
     * @param ArchiveFactory $archiveModelFactory
     */
    public function __construct(
        protected Archive $archiveModelResource,
        protected ArchiveFactory $archiveModelFactory
    ) {
    }

    /**
     * Save
     *
     * @param Data\ArchiveInterface $archiveModel
     * @return Data\ArchiveInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ArchiveInterface $archiveModel): Data\ArchiveInterface
    {
        try {
            $this->archiveModelResource->save($archiveModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save model %1', $archiveModel->getEntityId()));
        }

        return $archiveModel;
    }

    /**
     * Get by record id
     *
     * @param int $recordId
     * @return Data\ArchiveInterface|ModelArchive
     * @throws NoSuchEntityException
     */
    public function get($recordId): Data\ArchiveInterface
    {
        /** @var ModelArchive $model */
        $archiveModel = $this->archiveModelFactory->create();
        $this->archiveModelResource->load($archiveModel, $recordId);

        if (!$archiveModel->getEntityId()) {
            throw new NoSuchEntityException(__('Entity with specified ID "%1" not found.', $recordId));
        }

        return $archiveModel;
    }

    /**
     * Get by order id
     *
     * @param int $orderId
     * @return ModelArchive
     */
    public function getByOrderId($orderId): ModelArchive
    {
        /** @var ModelArchive $model */
        $model = $this->archiveModelFactory->create();
        $this->archiveModelResource->load($model, $orderId, 'order_id');

        return $model;
    }

    /**
     * Delete
     *
     * @param Data\ArchiveInterface $archiveModel
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function delete(Data\ArchiveInterface $archiveModel): bool
    {
        try {
            $this->archiveModelResource->delete($archiveModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove entity with ID%', $archiveModel->getRecordId()));
        }

        return true;
    }

    /**
     * Delete by id
     *
     * @param int $recordId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function deleteById($recordId): bool
    {
        try {
            $model = $this->get($recordId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }

    /**
     * Delete by order id
     *
     * @param int $orderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function deleteByOrderId($orderId): bool
    {
        try {
            $model = $this->getByOrderId($orderId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }
}
