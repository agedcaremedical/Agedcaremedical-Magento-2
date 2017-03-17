<?php
namespace Emipro\Productstocknotification\Model\ResourceModel;
class Stocknotification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    public function _construct() {
        $this->_init('emipro_stock_notification','id');
    }
}
