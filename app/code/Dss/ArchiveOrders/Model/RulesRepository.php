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

use Dss\ArchiveOrders\Api\RulesRepositoryInterface;
use Dss\ArchiveOrders\Api\Data;
use Dss\ArchiveOrders\Model\ResourceModel\Rules;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class RulesRepository implements RulesRepositoryInterface
{
    /**
     * RulesRepository constructor.
     *
     * @param Rules $rulesModelResource
     * @param RulesFactory $rulesModelFactory
     */
    public function __construct(
        protected Rules $rulesModelResource,
        protected RulesFactory $rulesModelFactory
    ) {
    }

    /**
     * Save
     *
     * @param Data\RulesInterface $rulesModel
     * @return Data\RulesInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\RulesInterface $rulesModel): Data\RulesInterface
    {
        try {
            $this->rulesModelResource->save($rulesModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save model %1', $rulesModel->getEntityId()));
        }

        return $rulesModel;
    }

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return Data\RulesInterface
     * @throws NoSuchEntityException
     */
    public function get($entityId): Data\RulesInterface
    {
        $rulesModel = $this->rulesModelFactory->create();
        $this->rulesModelResource->load($rulesModel, $entityId);

        if (!$rulesModel->getEntityId()) {
            throw new NoSuchEntityException(__('Entity with specified ID "%1" not found.', $entityId));
        }

        return $rulesModel;
    }

    /**
     * Delete
     *
     * @param Data\RulesInterface $rulesModel
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function delete(Data\RulesInterface $rulesModel): bool
    {
        try {
            $this->rulesModelResource->delete($rulesModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove entity with ID%', $rulesModel->getEntityId()));
        }

        return true;
    }

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId): bool
    {
        try {
            $model = $this->get($entityId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }
}
