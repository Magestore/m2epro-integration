<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Helper\Data;


/**
 * Class Process
 * @package Magestore\M2eIntegration\Helper\Data
 */
class Process extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magestore\M2eIntegration\Helper\Data|Factory
     */
    protected $magestoreHelper;
    /**
     * Data constructor.
     * @param Factory $magestoreHelper
     */
    public function __construct(
        \Magestore\M2eIntegration\Helper\Data $magestoreHelper
    ){
        $this->magestoreHelper = $magestoreHelper;
    }

    /**
     * @param string $model
     * @param int $warehouseId
     */
    public function integrationData($model,$warehouseId){
        try{
            $modelM2eListing = $this->magestoreHelper->getModel('M2eListing');
            $modelM2eListing->setWarehouseId($warehouseId)->setListingId($model->getId())->save();
        }catch(\Exception $e){
            return;
        }
    }

    /**
     * @param array $orderIds
     */
    public function prepareOrderIdIntegrationWithInventory($orderIds){
        try {
            $orderIdsM2e = $this->magestoreHelper->getModel('M2eOrder');
            if ($orderIds) {
                foreach ($orderIds as $orderId) {
                    $orderIdsM2e->setData('m2e_order_id',$orderId)->save();
                }
            }
        }catch(\Exception $e){
            return;
        }
    }

}