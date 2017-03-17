<?php
namespace Emipro\Productstocknotification\Model;
class Stocknotification extends \Magento\Framework\Model\AbstractModel {

    public function _construct() {
        $this->_init('Emipro\Productstocknotification\Model\ResourceModel\Stocknotification');
    }
}
