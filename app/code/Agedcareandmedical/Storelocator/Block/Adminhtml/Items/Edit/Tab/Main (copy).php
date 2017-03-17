<?php

// @codingStandardsIgnoreFile

namespace Agedcareandmedical\Storelocator\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;



class Main extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Item Information');
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
        $model = $this->_coreRegistry->registry('current_agedcareandmedical_storelocator_items');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
         $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Item'), 'title' => __('Title'), 'required' => true]
        );
        $fieldset->addField(
            'summary',
            'text',
            ['name' => 'summary', 'label' => __('Summary'), 'title' => __('Summary'), 'required' => true]
        );
        
        $fieldset->addField(
            'description',
            'text',
            ['name' => 'description', 'label' => __('Description'), 'title' => __('Description'), 'required' => true]
        );
        
         $fieldset->addField(
            'image',
            'image',
            ['name' => 'image', 'label' => __('Image'), 'title' => __('Image'), 'required' => true]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
