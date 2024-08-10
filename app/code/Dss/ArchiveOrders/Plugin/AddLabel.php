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
namespace Dss\ArchiveOrders\Plugin;

use Dss\ArchiveOrders\Model\ArchiveRepository;
use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Backend\Model\View\Result\Redirect;

class AddLabel
{
    /**
     * AddLabel constructor.
     *
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(
        protected ArchiveRepository $archiveRepository
    ) {
    }

    /**
     * After execute method
     *
     * @param array $subject
     * @param array $result
     * @return ResultPage|Redirect
     */
    public function afterExecute($subject, $result)
    {
        if ($result instanceof ResultPage) {
            $archiveMessage = __("Archived");
            $orderId = $subject->getRequest()->getParam("order_id");
            $order = $this->archiveRepository->getByOrderId($orderId);
            if ($order->getId()) {
                $currentTitle = $result->getConfig()->getTitle()->getShort() . " " . $archiveMessage;
                $result->getConfig()->getTitle()->prepend($currentTitle);
            }
        }
        return $result;
    }
}
