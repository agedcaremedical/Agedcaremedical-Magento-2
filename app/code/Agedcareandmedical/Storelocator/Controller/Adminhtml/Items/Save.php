<?php

namespace Agedcareandmedical\Storelocator\Controller\Adminhtml\Items;

class Save extends \Agedcareandmedical\Storelocator\Controller\Adminhtml\Items
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->_objectManager->create('Agedcareandmedical\Storelocator\Model\Items');
                $data = $this->getRequest()->getPostValue();
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                //start block upload image
if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
/*
* Save image upload
*/
try {
$base_media_path = 'storelocator/';
$uploader = $this->uploader->create(
['fileId' => 'image']
);
$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
$imageAdapter = $this->adapterFactory->create();
$uploader->addValidateCallback('image', $imageAdapter, 'validateUploadFile');
$uploader->setAllowRenameFiles(true);
$uploader->setFilesDispersion(false);
$mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

$result = $uploader->save(
$mediaDirectory->getAbsolutePath($base_media_path)
);
$data['image'] = $base_media_path.$result['file'];
} catch (\Exception $e) {
if ($e->getCode() == 0) {
$this->messageManager->addError($e->getMessage());
}
}
} else {
if (isset($data['image']) && isset($data['image']['value'])) {
    
    if (isset($data['image']['delete'])) {
        $mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        
        $pathToFile = $mediaDirectory->getAbsolutePath().$data['image']['value'];
        if (file_exists($pathToFile)) // if file exists
	    unlink($pathToFile); 

        $data['image'] = '';
        $data['delete_image'] = true;
    } elseif (isset($data['image']['value'])) {
        $data['image'] = $data['image']['value'];
    } else {
        $data['image'] = null;
    }
}
}
//end block upload image
                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }
                $model->setData($data);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('agedcareandmedical_storelocator/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('agedcareandmedical_storelocator/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('agedcareandmedical_storelocator/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('agedcareandmedical_storelocator/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('agedcareandmedical_storelocator/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('agedcareandmedical_storelocator/*/');
    }
}
