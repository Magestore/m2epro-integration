<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

/**
 * @method \Ess\M2ePro\Model\Ebay\Listing getComponentListing()
 * @method \Ess\M2ePro\Model\Ebay\Template\SellingFormat getComponentSellingFormatTemplate()
 * @method \Ess\M2ePro\Model\Ebay\Listing\Product getComponentProduct()
 */
namespace Magestore\M2eIntegration\Model\Rewrite\Ebay\Listing\Product;

class QtyCalculator extends \Ess\M2ePro\Model\Ebay\Listing\Product\QtyCalculator
{
    protected function getClearProductValue()
    {
        if($this->getSource('mode') == \Ess\M2ePro\Model\Template\SellingFormat::QTY_MODE_PRODUCT){
            $productId = $this->getMagentoProduct()->getProductId();
            $listing_id = $this->getListing()->getId();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
            $model = $resource->getModel('M2eListing');
            $warehouse_id = $model->getWarehouseByListing($listing_id,true);
            if($warehouse_id){
                $stockModel =  $objectManager->create('Magestore\InventorySuccess\Model\Warehouse\WarehouseStockRegistry');
                $stockItem = $stockModel->getStocks($warehouse_id ,$productId)->getLastItem();
                if($stockItem) {
                    return (int)$stockItem->getQty();
                }
            }
        }
        return parent::getClearProductValue();

    }
}