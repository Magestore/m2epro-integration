<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Model\ResourceModel\Magento\Product;

class Collection extends \Ess\M2ePro\Model\ResourceModel\Magento\Product\Collection
{
    public function joinStockItem($columnsMap = array('qty' => 'qty'))
    {
        /* integration Inventory with M2epro */
        $listing = $this->helperFactory->getObject('Data\GlobalData')->getValue('listing_for_products_add');
        $listing_id =   $listing->getId();
        $warehouse_id = '';
        if($listing_id){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
            $model = $resource->getModel('M2eListing');
            $warehouse_id = $model->getWarehouseByListing($listing_id,true);
        }
        if($warehouse_id){
            $this->joinTable(
                array('cisi' => $this->getTable('cataloginventory_stock_item')),
                'product_id = entity_id',
                $columnsMap,
                array(
                    //'stock_id'   => $warehouse_id,
                    'website_id' => $warehouse_id
                ),
                'inner'
            );
        }else{
            $this->joinTable(
                array('cisi' => $this->getTable('cataloginventory_stock_item')),
                'product_id = entity_id',
                $columnsMap,
                array(
                    'stock_id'   => \Magento\CatalogInventory\Model\Stock::DEFAULT_STOCK_ID,
                    'website_id' => $this->stockConfiguration->getDefaultScopeId()
                ),
                'left'
            );
        }
        return $this;
    }
    //########################################
}