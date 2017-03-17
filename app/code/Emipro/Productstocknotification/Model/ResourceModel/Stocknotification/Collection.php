<?php
namespace Emipro\Productstocknotification\Model\ResourceModel\Stocknotification;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection 
{
  	protected function _construct(){
        $this->_init('Emipro\Productstocknotification\Model\Stocknotification','Emipro\Productstocknotification\Model\ResourceModel\Stocknotification');
    }
}
