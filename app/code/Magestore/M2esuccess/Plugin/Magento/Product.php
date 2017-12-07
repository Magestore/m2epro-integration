<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Plugin\Magento;

class Product extends \Ess\M2ePro\Model\Magento\Product {

    public function aroundGetStockItem(\Ess\M2ePro\Model\Magento\Product $subject, $result)
    {
        $productId = $subject->getProductId();
        $storeId = $subject->getStoreId();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $_moduleManager =    $objectManager->create('\Magento\Framework\Module\Manager');

        $this->setStoreId($storeId);
        $this->setProductId($productId);
        $this->loadProduct();
        if (is_null($this->_productModel) && $this->_productId < 0) {
            throw new \Ess\M2ePro\Model\Exception('Load instance first');
        }
        if($_moduleManager->isEnabled('Magestore_M2esuccess')){
            $stockModel =  $objectManager->create('Magestore\InventorySuccess\Model\Warehouse\WarehouseStockRegistry');
            $warehouse_id = $this->helperFactory->getObject('Data\GlobalData')->getValue('warehouse_listing_for_integration_m2e');
            $stockItem = $stockModel->getStocks($warehouse_id ,$this->getProduct()->getId())->getLastItem();
            if($stockItem) {
                return $stockItem;
            }
        }
        return $this->stockRegistry->getStockItem(
            $this->getProduct()->getId(),
            $this->getProduct()->getStore()->getWebsiteId()
        );
    }
}
