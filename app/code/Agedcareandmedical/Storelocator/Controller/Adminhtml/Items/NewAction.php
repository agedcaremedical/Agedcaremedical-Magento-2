<?php

namespace Agedcareandmedical\Storelocator\Controller\Adminhtml\Items;

class NewAction extends \Agedcareandmedical\Storelocator\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
