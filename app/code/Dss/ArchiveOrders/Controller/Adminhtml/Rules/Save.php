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
namespace Dss\ArchiveOrders\Controller\Adminhtml\Rules;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Dss\ArchiveOrders\Model\RulesFactory;
use Dss\ArchiveOrders\Model\RulesRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::rules';

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param RulesRepository $rulesRepository
     * @param RulesFactory $rulesFactory
     */
    public function __construct(
        Context $context,
        protected RulesRepository $rulesRepository,
        protected RulesFactory $rulesFactory
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
        if ($this->getRequest()->isPost() && $postData = $this->getRequest()->getPostValue()) {
            try {
                if ($ruleId = $this->getRequest()->getParam("entity_id")) {
                    $ruleModel = $this->rulesRepository->get($ruleId);
                } else {
                    $ruleModel = $this->rulesFactory->create();
                }
                $data = [
                    'title' => $postData["title"],
                    'scope' => $postData["scope"],
                    'action' => $postData["action"],
                    'time' => $postData["time"],
                    'is_active' => $postData["is_active"],
                    'order_statuses' => implode(",", $postData["order_statuses"])
                ];
                $ruleModel->addData($data);
                $this->rulesRepository->save($ruleModel);
                $this->messageManager->addSuccessMessage(__('You saved the rule'));
                $redirectResult->setPath('deleteorders/rules');
                return $redirectResult;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__("Invalid request"));
        }
        $redirectResult->setPath('deleteorders/rules');
        return $redirectResult;
    }
}
