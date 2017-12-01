<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Observer;


abstract class M2esuccess
{
    /**
     * @var \Magestore\InventorySuccess\Api\Logger\LoggerInterface
     */
    protected $moduleManager;
    protected $helper;

    public function __construct(
        \Magento\Framework\Module\Manager $moduleManager,
        \Magestore\M2esuccess\Helper\Data $helper
    ) {
        $this->moduleManager = $moduleManager;
        $this->helper = $helper;
    }

    /**
     * @return bool
     */
    public function isM2eProActive()
    {
        $result = false;
        if ($this->moduleManager->isEnabled('Magestore_M2esuccess') && $this->moduleManager->isEnabled('Ess_M2ePro') ) {
            $result = true;
        }
        return $result;
    }

    /**
     * @param $m2eOrder
     * @param $product_id
     * @return string
     */
    public function prepareWarehouseIdFromM2eListing($m2eOrder,$product_id){
        $warehouseId = '';
        $m2epro_listing_id = 0;
        $component_mode = $m2eOrder->getComponentMode();
        if($m2eOrder->hasListingItems()) {
            $channelItems = $m2eOrder->getChannelItems();
            foreach ($channelItems as $product_purchased) {
                if ($product_purchased->getProductId() == $product_id) {
                    if ($component_mode == \Ess\M2ePro\Helper\Component\Ebay::NICK) {
                        $m2epro_listing_id = $this->prepareFromEbay($product_purchased);
                    }
                    if ($component_mode == \Ess\M2ePro\Helper\Component\Amazon::NICK) {
                        $m2epro_listing_id = $this->prepareFromAmazon($product_purchased);
                    }
                    $warehouseId = $this->helper->getModel('M2eListing')->getWarehouseByListing($m2epro_listing_id, true);
                    break;
                }
            }
        }
        return $warehouseId;
    }

    /**
     * @param $product_purchased
     * @return $listing_id
     */
    public function prepareFromEbay($product_purchased){
        $listing_id = 0;
        $listingItem = $this->helper->getM2eHelperFactory('Component\Ebay')
            ->getListingProductByEbayItem($product_purchased->getItemId(),$product_purchased->getAccountId());
        if($listingItem){
            $listing_id = $listingItem->getListingId();
        }
        return $listing_id;
        /*
        $listing_id = Mage::helper('M2ePro/Component_Ebay')->getModel('Listing_Product')->getCollection()
            ->addFieldToFilter('ebay_item_id',$product_purchased->getId())
            ->getLastItem()->getListingId();
        return $listing_id;
        */
    }
    /**
     * @param $product_purchased
     * @return $listing_id
     */
    public function prepareFromAmazon($product_purchased){
        $listing_id = 0;
        $amazonfactory = $this->helper->getAmazonFactory();
        /** @var $listingProduct \Ess\M2ePro\Model\Listing\Product */
        $listingProduct = $amazonfactory->getObjectLoaded('Listing\Product', $product_purchased->getProductId());
        if($listingProduct){
            $listing_id = $listingProduct->getListing()->getListingId();
        }
        return $listing_id;
    }
    /**
     * @param $warehouseId
     * @param $warehouse
     */
    public function setWarehouseObject($warehouseId,$warehouse){
        $warehouseM2e = $this->helper->getModel('Config\Warehouse')->getWarehouseModel()->getCollection()
            ->addFieldToFilter('warehouse_id',$warehouseId)
            ->getFirstItem();
        if($warehouseM2e){
            $warehouse->setData($warehouseM2e->getData());
            $warehouse->setWarehouseId($warehouseM2e->getWarehouseId());
        }
    }
}