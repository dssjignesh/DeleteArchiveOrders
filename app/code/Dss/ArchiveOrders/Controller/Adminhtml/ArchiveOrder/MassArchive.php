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
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Dss\ArchiveOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class MassArchive extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::archive_action';

    /**
     * MassArchive constructor.
     *
     * @param Context $context
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param Filter $filter
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        protected OrderCollectionFactory $orderCollectionFactory,
        protected Filter $filter,
        protected Data $helper
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
        $collection = $this->filter->getCollection($this->orderCollectionFactory->create());
        $redirectResult = $this->resultRedirectFactory->create();
        try {
            foreach ($collection as $item) {
                $this->helper->archiveOrder($item->getId());
            }
            $this->messageManager->addSuccessMessage(
                __('%1 order(s) were successfully archived.', $collection->getSize())
            );
            $redirectResult->setPath('sales/order');
            return $redirectResult;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $redirectResult->setPath('sales/order');
        return $redirectResult;
    }
}
