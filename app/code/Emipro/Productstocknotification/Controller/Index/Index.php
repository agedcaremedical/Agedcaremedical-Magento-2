<?php

namespace Emipro\Productstocknotification\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action {
    
    protected $_currency;

    protected $_storeManager;
    
    protected $date;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Store\Model\StoreManagerInterface $storeManager       
    ){
        parent::__construct($context);
        $this->_currency = $currency;
        $this->_storeManager = $storeManager;
        $this->date = $date;
    }

    public function execute() 
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $request = $this->getRequest()->getPost();
        //save data to Notified customer
        $collection = $objectManager->create('Emipro\Productstocknotification\Model\Stocknotification')->getCollection();
        $collection->addFieldToFilter('product_id',$request['pro_id'])
                    ->addFieldToFilter('email_id',$request['email']);
        if($collection->count()){
            $this->messageManager->addNotice(__("Thank you for your interest. You already subscribed for notification."));
        }else{
            $data = $objectManager->create('Emipro\Productstocknotification\Model\Stocknotification');
            $data->setData('product_id',$request['pro_id']);
            $data->setData('email_id',$request['email']);
            $data->setData('created_at',$this->date->gmtDate());
            $data->save();
            $this->messageManager->addSuccess(__("Thank you for your interest. You will be notified by email when the product is available."));
        }
    }   
}