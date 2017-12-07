<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2esuccess\Helper\Data;

    /**
     * Helper Data.
     * @category Magestore
     * @package  Magestore_InventorySuccess
     * @module   Inventorysuccess
     * @author   Magestore Developer
     */

/**
 * Class Data
 * @package Magestore\InventorySuccess\Helper
 */
class Warehouse extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $warehouseFactory;

    /**
     * Warehouse constructor.
     * @param \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory
     */
    public function __construct(
        \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory
    )
    {
        $this->warehouseFactory = $warehouseProductFactory;
    }

    /**
     * Get all enabled warehouses in system
     *
     * @return array
     */
    public function getAllWarehouses()
    {
        return $this->warehouseFactory->toOptionArray();
    }
}