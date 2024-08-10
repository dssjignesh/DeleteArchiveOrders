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
use Dss\ArchiveOrders\Model\ArchiveRepository;
use Dss\ArchiveOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::delete_action';

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        protected ArchiveRepository $archiveRepository,
        protected Data $helper
    ) {
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectRoute = "sales/order";
        if ($orderId = $this->getRequest()->getParam("order_id")) {
            try {
                $archiveOrder = $this->archiveRepository->getByOrderId($orderId);
                if ($archiveOrder->getId()) {
                    $redirectRoute = "deleteorders/archiveorder";
                }
                $this->helper->deleteOrder($orderId);
                $this->messageManager->addSuccessMessage(__('Order was successfully deleted'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath($redirectRoute);
        return $redirectResult;
    }
}
