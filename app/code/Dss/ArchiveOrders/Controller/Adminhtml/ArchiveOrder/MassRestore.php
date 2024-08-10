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
namespace Dss\ArchiveOrders\Controller\Adminhtml\ArchiveOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Dss\ArchiveOrders\Model\ArchiveRepository;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;

class MassRestore extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::restore_action';

    /**
     * Restore constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        protected ArchiveRepository $archiveRepository,
        protected CollectionFactory $collectionFactory,
        protected Filter $filter,
        protected DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->dataPersistor->set('mass_action_flag', 1);
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $this->dataPersistor->clear('mass_action_flag');
        $redirectResult = $this->resultRedirectFactory->create();
        try {
            foreach ($collection as $item) {
                $this->archiveRepository->deleteByOrderId($item->getId());
            }
            $this->messageManager->addSuccessMessage(
                __('%1 order(s) were successfully restored.', $collection->getSize())
            );
            $redirectResult->setPath('deleteorders/archiveorder');
            return $redirectResult;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $redirectResult->setPath('deleteorders/archiveorder');
        return $redirectResult;
    }
}
