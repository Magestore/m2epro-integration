<?php

/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Helper\Data;


/**
 * Class Process
 * @package Magestore\M2esuccess\Helper\Data
 */
class Process extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magestore\M2esuccess\Helper\Data|Factory
     */
    protected $magestoreHelper;
    /**
     * Data constructor.
     * @param Factory $magestoreHelper
     */
    public function __construct(
        \Magestore\M2esuccess\Helper\Data $magestoreHelper
    ){
        $this->magestoreHelper = $magestoreHelper;
    }

    /**
     * @param $model
     * @param $w_id
     */
    public function integrationData($model,$w_id){
        try{
            $modelM2eListing = $this->magestoreHelper->getModel('M2eListing');
            $modelM2eListing->setWarehouseId($w_id)->setListingId($model->getId())->save();
        }catch(\Exception $e){
            return;
        }
    }

    /**
     * @param $orderIds
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