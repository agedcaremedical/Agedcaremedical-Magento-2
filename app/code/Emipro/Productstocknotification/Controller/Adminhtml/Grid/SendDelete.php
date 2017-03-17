<?php
namespace Emipro\Productstocknotification\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Emipro\Productstocknotification\Model\ResourceModel\Stocknotification\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class SendDelete  extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $deleteids = $this->getRequest()->getPost('id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $objectManager->create('Emipro\Productstocknotification\Helper\Data')->getStockId($deleteids);
        $delete = count($deleteids);
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been send Email and Deleted.', $delete));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}