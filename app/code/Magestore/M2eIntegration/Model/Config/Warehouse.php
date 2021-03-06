<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

/**
 * Order Statuses source model
 */
namespace Magestore\M2eIntegration\Model\Config;

class Warehouse implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magestore\InventorySuccess\Model\Warehouse
     */
    protected $warehouseFactory;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Warehouse constructor.
     * @param \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->warehouseFactory = $warehouseProductFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return \Magestore\InventorySuccess\Model\Warehouse
     */
    public function getWarehouseModel(){
        return $this->warehouseFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->warehouseFactory->toOptionArray();
    }

    /**
     * Check if Ebay store is associated with a warehouses
     *
     * @return bool
     */
    public function isEbayLinkedWithWarehouse($componentMode)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $result = false;
        if (strcmp($this->scopeConfig->getValue('m2eintegration/integrate_m2epro/associated_with_'.$componentMode,$storeScope),2) == 0)
        {
            $result = true;
        }
        return $result;
    }

    /**
     * Get warehouse associated with Ebay store in config
     *
     * @return mixed
     */
    public function getWarehouseForM2ePro($componentMode)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        if ($this->isEbayLinkedWithWarehouse($componentMode))
        {
            if ($this->scopeConfig->getValue('m2eintegration/integrate_m2epro/warehouse_'.$componentMode,$storeScope))
            {
                $warehouseId = $this->scopeConfig->getValue('m2eintegration/integrate_m2epro/warehouse_'.$componentMode,$storeScope);
                return $warehouseId;
            }
        }
        return null;
    }
}
