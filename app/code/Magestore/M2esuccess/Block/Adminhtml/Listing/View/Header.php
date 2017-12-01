<?php

namespace Magestore\M2eSuccess\Block\Adminhtml\Listing\View;

class Header extends \Ess\M2ePro\Block\Adminhtml\Magento\AbstractBlock
{
    protected $isListingViewMode = false;
    protected $_template = 'listing/view/header.phtml';

    //########################################

    public function isListingViewMode()
    {
        return $this->isListingViewMode;
    }

    public function setListingViewMode($mode)
    {
        $this->isListingViewMode = $mode;
        return $this;
    }

    //########################################

    public function getComponent()
    {
        if ($this->getListing()->isComponentModeEbay()) {
            return $this->__('eBay');
        }

        if ($this->getListing()->isComponentModeAmazon()) {
            return $this->__('Amazon');
        }

        if ($this->getListing()->isComponentModeBuy()) {
            return $this->__('Rakuten');
        }

        return '';
    }

    public function getProfileTitle()
    {
        return $this->cutLongLines($this->getListing()->getTitle());
    }

    public function getAccountTitle()
    {
        return $this->cutLongLines($this->getListing()->getAccount()->getTitle());
    }

    public function getMarketplaceTitle()
    {
        return $this->cutLongLines($this->getListing()->getMarketplace()->getTitle());
    }

    public function getStoreViewBreadcrumb($cutLongValues = true)
    {
        $breadcrumb = $this->getHelper('Magento\Store')->getStorePath($this->getListing()->getStoreId());

        return $cutLongValues ? $this->cutLongLines($breadcrumb) : $breadcrumb;
    }

    public function getWarehouse(){
        $listing_id = $this->getListing()->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magestore\M2esuccess\Helper\Data');
        $model = $resource->getModel('M2eListing');
        $warehouse_listing = $model->getWarehouseByListing($listing_id);
        return $this->cutLongLines($warehouse_listing);
    }

    //########################################

    private function cutLongLines($line)
    {
        if (strlen($line) < 50) {
            return $line;
        }

        return substr($line, 0, 50) . '...';
    }

    //########################################

    /**
     * @return \Ess\M2ePro\Model\Listing
     */
    private function getListing()
    {
        return $this->getData('listing');
    }

    //########################################
}