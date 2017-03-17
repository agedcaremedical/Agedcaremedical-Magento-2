<?php
namespace Magento\Catalog\Block\Product\ImageBuilder;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\ImageBuilder
 */
class Interceptor extends \Magento\Catalog\Block\Product\ImageBuilder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\ImageFactory $helperFactory, \Magento\Catalog\Block\Product\ImageFactory $imageFactory)
    {
        $this->___init();
        parent::__construct($helperFactory, $imageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(\Magento\Catalog\Model\Product $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setProduct');
        if (!$pluginInfo) {
            return parent::setProduct($product);
        } else {
            return $this->___callPlugins('setProduct', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setImageId($imageId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setImageId');
        if (!$pluginInfo) {
            return parent::setImageId($imageId);
        } else {
            return $this->___callPlugins('setImageId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setAttributes');
        if (!$pluginInfo) {
            return parent::setAttributes($attributes);
        } else {
            return $this->___callPlugins('setAttributes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'create');
        if (!$pluginInfo) {
            return parent::create();
        } else {
            return $this->___callPlugins('create', func_get_args(), $pluginInfo);
        }
    }
}
