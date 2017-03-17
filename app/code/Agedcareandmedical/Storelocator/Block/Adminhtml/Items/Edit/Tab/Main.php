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
            'store_name',
            'text',
            ['name' => 'store_name', 'label' => __('Store Name'), 'title' => __('Store Name'), 'required' => true]
        );
         $fieldset->addField(
            'latitude',
            'text',
            ['name' => 'latitude', 'label' => __('Latitude'), 'title' => __('Latitude'), 'required' => true]
        );
         $fieldset->addField(
            'longitude',
            'text',
            ['name' => 'longitude', 'label' => __('Longitude'), 'title' => __('Longitude'), 'required' => true]
        );
        $fieldset->addField(
            'store_address',
            'textarea',
            ['name' => 'store_address', 'label' => __('Store Address'), 'title' => __('Store Address'), 'required' => true]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
