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
namespace Dss\ArchiveOrders\Cron;

use Dss\ArchiveOrders\Model\ResourceModel\Rules\CollectionFactory as RulesCollection;
use Dss\ArchiveOrders\Model\ResourceModel\Order\CollectionFactory as OrderCollection;
use Dss\ArchiveOrders\Helper\Data;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;

class OrderProcess
{
    /**
     * OrderProcess constructor.
     *
     * @param RulesCollection $rulesCollection
     * @param OrderCollection $orderCollection
     * @param DataPersistorInterface $dataPersistor
     * @param Data $helper
     */
    public function __construct(
        protected RulesCollection $rulesCollection,
        protected OrderCollection $orderCollection,
        protected DataPersistorInterface $dataPersistor,
        protected Data $helper
    ) {
    }

    /**
     * Execute
     */
    public function execute()
    {
        $this->dataPersistor->set('isSecureArea', true);
        $currentDate = date("Y-m-d H:i:s");
        $rulesCollection = $this->rulesCollection->create()
            ->addFieldToFilter('is_active', 1)
            ->load();
        foreach ($rulesCollection as $rule) {
            $scope = $rule->getScope();//either sales_order_grid or archive_order_grid
            $orderStatuses = explode(",", $rule->getOrderStatuses());
            $action = $rule->getAction();//either delete or archive
            $formatDate = date('Y-m-d H:i:s', strtotime($currentDate . ' -' . $rule->getTime() . ' day'));
            if ($action == "1") {
                $this->archiveOrders($orderStatuses, $formatDate);
            } elseif ($action == "0") {
                $this->deleteOrders($scope, $orderStatuses, $formatDate);
            }
        }
        $this->dataPersistor->clear('isSecureArea');
    }

    /**
     * Archive orders
     *
     * @param string|bool $orderStatuses
     * @param string $formatDate
     * @throws CouldNotSaveException
     */
    public function archiveOrders($orderStatuses, $formatDate)
    {
        $orderCollection = $this->orderCollection->create();
        //join the archive table to check whether the order has already been archived.
        $orderCollection->joinArchiveTable()
            ->addFieldToFilter('updated_at', ['lteq' => $formatDate])
            ->addFieldToFilter('status', ['in' => $orderStatuses])
            ->load();

        if ($orderCollection->getSize()) {
            foreach ($orderCollection as $order) {
                $this->helper->archiveOrder($order->getId());
            }
        }
    }

    /**
     * Delete orders
     *
     * @param string $scope
     * @param string|bool $orderStatuses
     * @param string $formatDate
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function deleteOrders($scope, $orderStatuses, $formatDate)
    {
        $orderCollection = $this->orderCollection->create();
        if ($scope == "1") {
            $orderCollection->addFieldToFilter('updated_at', ['lteq' => $formatDate]);
        } elseif ($scope == "0") {
            $orderCollection->joinArchiveTable(["order_id", "archived_at"], true)
                ->addFieldToFilter('archived_at', ['lteq' => $formatDate]);
        }
        $orderCollection->addFieldToFilter('status', ['in' => $orderStatuses])->load();
        if ($orderCollection->getSize()) {
            foreach ($orderCollection as $order) {
                $this->helper->deleteOrder($order->getId());
            }
        }
    }
}
