<?php

// @codingStandardsIgnoreFile

namespace Agedcare\Brochure\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\App\ObjectManager;


class Main extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Brochure Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Brochure Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_agedcare_brochure_items');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Brochure Information')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
         $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Brochure Title'), 'title' => __('Title'), 'required' => true]
        );
        $fieldset->addField(
            'product_id',
            'select',
            ['name' => 'product_id', 'label' => __('Select Product'), 'title' => __('Select Product'), 'required' => true,'onchange'=>'addProductName(this)','values'=>$this->_productArrayOpt()]
        );
        $fieldset->addField(
            'product_name',
            'hidden',
            ['name' => 'product_name']
        );
        
         $fieldset->addField(
            'image',
            'file',
            ['name' => 'image', 'label' => __('Upload Brochure'), 'title' => __('Upload Brochure'), 'required' => true,'note'=>'upload only pdf file']
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    
    public function _productArrayOpt(){
        $objManager = ObjectManager::getInstance();
        $productCollection = $objManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')->addAttributeToSelect('*')->addAttributeToFilter('status',1);
        $productCollection->load();
        $productArr = array();
        $productArr[0] = array('value'=>'','label'=>'');
        foreach($productCollection as $product){
            $productArr[] = array('value'=>$product->getId(),'label'=>$product->getName());
        }
        
        return $productArr;
    }
}
