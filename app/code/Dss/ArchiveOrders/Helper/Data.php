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
namespace Dss\ArchiveOrders\Helper;

use Magento\Sales\Model\Order\InvoiceRepository;
use Magento\Sales\Model\Order\CreditmemoRepository;
use Magento\Sales\Model\Order\ShipmentRepository;
use Dss\ArchiveOrders\Model\ArchiveFactory;
use Dss\ArchiveOrders\Model\ArchiveRepository;
use Magento\Sales\Model\OrderRepository;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

class Data extends AbstractHelper
{
    /**
     * Data constructor.
     *
     * @param InvoiceRepository $invoiceRepository
     * @param CreditmemoRepository $creditMemoRepository
     * @param ShipmentRepository $shipmentRepository
     * @param ArchiveRepository $archiveRepository
     * @param ArchiveFactory $archiveFactory
     * @param OrderRepository $orderRepository

     */
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected CreditmemoRepository $creditMemoRepository,
        protected ShipmentRepository $shipmentRepository,
        protected ArchiveRepository $archiveRepository,
        protected ArchiveFactory $archiveFactory,
        protected OrderRepository $orderRepository
    ) {
    }

    /**
     * Delete order entities such as invoices, shipments and credit memos.
     *
     * @param array $order
     * @throws CouldNotDeleteException
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function deleteOrderEntities($order)
    {
        $invoices = $order->getInvoiceCollection();
        $shipments = $order->getShipmentsCollection();
        $creditMemos = $order->getCreditmemosCollection();

        foreach ($invoices as $invoice) {
            $this->invoiceRepository->deleteById($invoice->getId());
        }
        foreach ($shipments as $shipment) {
            $this->shipmentRepository->deleteById($shipment->getId());
        }
        foreach ($creditMemos as $creditMemo) {
            $creditMemoEntity = $this->creditMemoRepository->get($creditMemo->getId());
            $this->creditMemoRepository->delete($creditMemoEntity);
        }
    }

    /**
     * Archive order
     *
     * @param int $orderId
     * @return bool
     * @throws CouldNotSaveException
     */
    public function archiveOrder($orderId)
    {
        $archiveModel = $this->archiveFactory->create();
        $archiveModel->addData([
            'order_id' => $orderId
        ]);
        $this->archiveRepository->save($archiveModel);
        return true;
    }

    /**
     * Delete order
     *
     * @param int $orderId
     * @return bool
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function deleteOrder($orderId)
    {
        $order = $this->orderRepository->get($orderId);
        $this->deleteOrderEntities($order);
        $this->orderRepository->delete($order);
        return true;
    }
}
