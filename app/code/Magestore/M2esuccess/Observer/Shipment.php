<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class Shipment extends \Magestore\M2esuccess\Observer\M2esuccess
    implements ObserverInterface
{

    /**
     * @var \Magestore\InventorySuccess\Api\Logger\LoggerInterface
     */
    protected $logger;
    protected $_coreRegistry;


    public function __construct(
        \Magestore\InventorySuccess\Api\Logger\LoggerInterface $logger,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magestore\M2esuccess\Helper\Data $helper
    ) {
        $this->logger = $logger;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($moduleManager,$helper);
    }

    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        try{
            if ($this->isM2eProActive()) {

                $warehouse = $observer->getEvent()->getWarehouse();
                $item = $observer->getEvent()->getItem();
                $orderId = $observer->getEvent()->getOrderId();
                /* check orders processing by m2e */
                $m2eOrderId = 0;
                $m2eOrder = $this->helper->getM2eModelFactory('Order')->getCollection()->addFieldToFilter('magento_order_id',$orderId)->getLastItem();
                if($m2eOrder){
                    $m2eOrderId = $m2eOrder->getId();
                }
                $check_m2e_order_id = $this->helper->getModel('M2eOrder')->checkByM2eOrderId($m2eOrderId);
                if( $check_m2e_order_id ){
                    $m2eOrder =$this->helper->getM2eModelFactory('Order')->load($m2eOrderId);
                    $warehouseId = $this->prepareWarehouseIdFromM2eListing($m2eOrder,$item->getProductId());
                    if($warehouseId){
                        $this->setWarehouseObject($warehouseId,$warehouse);
                        return;
                    }
                }
            }
        }catch(\Exception $e) {
            /* log issue */
            $this->logger->log($e->getMessage(), 'shipment');
        }
    }
}