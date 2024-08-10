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
namespace Dss\ArchiveOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;

class OrderStatusesOptionsProvider implements OptionSourceInterface
{
    /**
     * OrderStatusesOptionsProvider constructor.
     *
     * @param CollectionFactory $statusCollectionFactory
     */
    public function __construct(
        protected CollectionFactory $statusCollectionFactory
    ) {
    }

    /**
     * Get status options
     *
     * @return array
     */
    public function getStatusOptions(): array
    {
        $options = $this->statusCollectionFactory->create()->toOptionArray();
        return $options;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->getStatusOptions();
    }
}
