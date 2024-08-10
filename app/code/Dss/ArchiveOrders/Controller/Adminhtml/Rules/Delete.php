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
use Dss\ArchiveOrders\Model\RulesRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Dss_ArchiveOrders::rules';

    /**
     * Restore constructor.
     *
     * @param Context $context
     * @param RulesRepository $rulesRepository
     */
    public function __construct(
        Context $context,
        protected RulesRepository $rulesRepository
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
        if ($ruleId = $this->getRequest()->getParam("entity_id")) {
            try {
                $rule = $this->rulesRepository->get($ruleId);
                $this->rulesRepository->delete($rule);
                $this->messageManager->addSuccessMessage(__('Rule was successfully deleted'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath('deleteorders/rules');
        return $redirectResult;
    }
}
