<?php

namespace Agedcare\Brochure\Model;

class Items extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Agedcare\Brochure\Model\Resource\Items');
    }
    
    public function loadByProductId($id){
        $collection = $this->getCollection()->addFieldToFilter('product_id',$id);
        $brochure = '';
        foreach($collection as $item){
            $brochure = $item->getImage();
        }
        return $brochure;
    }
    
    public function checkDataValidation($mod,$data){
        $valid = true;
        if(!$mod->hasData('id')){
            $brochure = $this->loadByProductId($data['product_id']);
            if(count($brochure)>0){
                $valid = false;
            }
        }
        return $valid;
    }
}
