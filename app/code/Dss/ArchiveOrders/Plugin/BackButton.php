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

class BackButton
{
    /**
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(
        protected ArchiveRepository $archiveRepository
    ) {
    }

    /**
     * After get back url method
     *
     * @param array $subject
     * @param string $url
     * @return string
     */
    public function afterGetBackUrl($subject, $url): string
    {
        $order_id = $subject->getRequest()->getParam("order_id");
        $order = $this->archiveRepository->getByOrderId($order_id);
        if ($order->getId()) {
            return $subject->getUrl("deleteorders/archiveorder");
        }
        return $url;
    }
}
