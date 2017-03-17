<?php

namespace Agedcare\Brochure\Controller\Adminhtml\Items;

class Index extends \Agedcare\Brochure\Controller\Adminhtml\Items
{
    /**
     * Items list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::products_brochure');
        $resultPage->getConfig()->getTitle()->prepend(__('Brochure Items'));
        $resultPage->addBreadcrumb(__('Agedcare'), __('Agedcare'));
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}
