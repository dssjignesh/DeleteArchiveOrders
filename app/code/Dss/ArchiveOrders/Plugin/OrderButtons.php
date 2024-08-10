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

use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Context;
use Dss\ArchiveOrders\Model\ArchiveRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\AuthorizationInterface;

class OrderButtons
{
    public const ADMIN_ACL_RESOURCE_PREFIX = 'Dss_ArchiveOrders::';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var int
     */
    protected $orderId;

    /**
     * @var ButtonList
     */
    protected $buttonList;

    /**
     * OrderButtons constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(
        Context $context,
        protected ArchiveRepository $archiveRepository
    ) {
        $this->context = $context;
        $this->request = $context->getRequest();
        $this->authorization = $context->getAuthorization();
        $this->orderId = $this->request->getParam("order_id");
    }

    /**
     * After method for get button list
     *
     * @param Context $context
     * @param ButtonList $buttonList
     * @return ButtonList
     */
    public function afterGetButtonList(Context $context, ButtonList $buttonList): ButtonList
    {
        $this->buttonList = $buttonList;
        $archivedOrder = $this->archiveRepository->getByOrderId($this->orderId);
        if ($this->request->getFullActionName() == 'sales_order_view') {
            $this->generateButton('delete');
            if ($archivedOrder->getId()) {
                $this->generateButton('restore');
            } else {
                $this->generateButton('archive');
            }
        }
        return $this->buttonList;
    }

    /**
     * Generate button
     *
     * @param string $action
     */
    private function generateButton($action)
    {
        if ($this->authorization->isAllowed(self::ADMIN_ACL_RESOURCE_PREFIX . $action . '_action')) {
            $urlPath = $action == 'delete' ? 'deleteorders/deleteorder/' : 'deleteorders/archiveorder/';
            $message = __('Are you sure you want to ' . $action . ' an order?');
            $this->buttonList->add(
                $action . '_button',
                [
                    'label' => __(ucfirst($action)),
                    'onclick' => "confirmSetLocation(
                    '{$message}', 
                    '{$this->createUrl($urlPath . $action, $this->orderId)}')",
                ]
            );
        }
    }

    /**
     * Create url
     *
     * @param string $path
     * @param int $order_id
     * @return string
     */
    public function createUrl($path, $order_id): string
    {
        return $this->context->getUrlBuilder()->getUrl($path, ['order_id' => $order_id]);
    }
}
