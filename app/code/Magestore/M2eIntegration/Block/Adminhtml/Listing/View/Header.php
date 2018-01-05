<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Block\Adminhtml\Listing\View;

class Header extends \Ess\M2ePro\Block\Adminhtml\Listing\View\Header
{
    protected $_template = 'listing/view/header.phtml';

    /**
     * @return string
     */
    public function getWarehouse(){
        $listing_id = $this->getListing()->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
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