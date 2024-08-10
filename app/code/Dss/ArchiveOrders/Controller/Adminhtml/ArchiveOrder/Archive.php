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
use Magento\Framework\Exception\LocalizedException;
use Dss\ArchiveOrders\Helper\Data;
use Magento\Framework\Controller\Result\Redirect;

class Archive extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::archive_action';

    /**
     * Archive constructor.
     *
     * @param Context $context
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        protected Data $helper
    ) {
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return Redirect
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        if ($orderId = $this->getRequest()->getParam("order_id")) {
            try {
                $this->helper->archiveOrder($orderId);
                $this->messageManager->addSuccessMessage(__('Order was successfully archived'));
                $redirectResult->setPath('sales/order/view', ["order_id" => $orderId]);
                return $redirectResult;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath('sales/order');
        return $redirectResult;
    }
}
