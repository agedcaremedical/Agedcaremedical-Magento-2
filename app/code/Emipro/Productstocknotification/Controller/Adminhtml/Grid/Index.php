<?php
namespace Emipro\Productstocknotification\Controller\Adminhtml\Grid;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    protected $resultPageFactory;
 
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $objectManager->create("Emipro\Productstocknotification\Helper\Data")->validateProductstocknotifyData();
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Emipro_Productstocknotification::productstocknotification');
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('Manage Product Stock Notifications'), __('Manage Product Stock Notifications'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Product Stock Notifications'));
        return $resultPage;
    }
}