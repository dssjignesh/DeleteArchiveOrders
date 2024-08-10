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
namespace Dss\ArchiveOrders\Controller\Adminhtml\DeleteOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Dss\ArchiveOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class MassDelete extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::delete_action';

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param Filter $filter
     * @param Data $helper
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        protected OrderCollectionFactory $orderCollectionFactory,
        protected Filter $filter,
        protected Data $helper,
        protected DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->dataPersistor->set('mass_action_flag', 1);
        $collection = $this->filter->getCollection($this->orderCollectionFactory->create());
        $this->dataPersistor->clear('mass_action_flag');
        $redirectResult = $this->resultRedirectFactory->create();
        $collectionSize = $collection->getSize();
        try {
            foreach ($collection as $item) {
                $this->helper->deleteOrder($item->getId());
            }
            $this->messageManager->addSuccessMessage(__('%1 order(s) have been deleted.', $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $redirectResult->setUrl($this->_redirect->getRefererUrl());
        return $redirectResult;
    }
}
