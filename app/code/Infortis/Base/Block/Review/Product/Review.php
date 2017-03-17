<?php
class Review extends Magento\Review\Block\Product\Review
{
    public function setTabTitle()
    {
        $title = $this->getCollectionSize()
            ? __('Reviews 123 %1', '<span class="counter">' . $this->getCollectionSize() . '</span>')
            : __('Reviews 234');
        $this->setTitle($title);
    }
}
