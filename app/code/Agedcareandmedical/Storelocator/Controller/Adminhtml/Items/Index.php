<?php

namespace Agedcareandmedical\Storelocator\Controller\Adminhtml\Items;

class Index extends \Agedcareandmedical\Storelocator\Controller\Adminhtml\Items
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
        $resultPage->setActiveMenu('Agedcareandmedical_Storelocator::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__('Storelocator Items'));
        $resultPage->addBreadcrumb(__('Agedcareandmedical'), __('Agedcareandmedical'));
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}
