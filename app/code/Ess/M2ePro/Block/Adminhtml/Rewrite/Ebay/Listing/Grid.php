<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Ess\M2ePro\Block\Adminhtml\Rewrite\Ebay\Listing;


class Grid extends \Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Grid
{
    /**
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function callbackColumnTitle($value, $row, $column, $isExport)
    {

        $html = parent::callbackColumnTitle($value, $row, $column, $isExport);
        /* m2e integration with Inventory_success*/
        $warehouse =  $this->__('Warehouse');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
        $model = $resource->getModel('M2eListing');
        $warehouse_listing = $model->getWarehouseByListing($row->getId());
        if($warehouse_listing && $warehouse_listing!=''){
            $value .= <<<HTML
                <div>
                    <span style="font-weight: bold">{$warehouse}</span>: <span style="color: red">{$warehouse_listing}</span>
                </div>
HTML;
        }
        return $html.$value;
    }
}