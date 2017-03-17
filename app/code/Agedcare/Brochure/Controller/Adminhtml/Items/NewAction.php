<?php

namespace Agedcare\Brochure\Controller\Adminhtml\Items;

class NewAction extends \Agedcare\Brochure\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
