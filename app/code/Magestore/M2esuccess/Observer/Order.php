<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2esuccess\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class Order extends \Magestore\M2esuccess\Observer\M2esuccess
    implements ObserverInterface
{

    /**
     * @var \Magestore\InventorySuccess\Api\Logger\LoggerInterface
     */
    protected $logger;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Order constructor.
     * @param \Magestore\InventorySuccess\Api\Logger\LoggerInterface $logger
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magestore\M2esuccess\Helper\Data $helper
     */
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
        //$order = $observer->getEvent()->getOrder();
        $warehouse = $observer->getEvent()->getWarehouse();
        try{
            if ($this->isM2eProActive()) {
                $m2eOrder = $this->_coreRegistry->registry('os_m2e_order_create_before');
                if ($m2eOrder) {
                    if($observer->getEvent()->getProductId() != 0){
                        $product_id = $observer->getEvent()->getProductId();
                        $warehouseId = $this->prepareWarehouseIdFromM2eListing($m2eOrder,$product_id);
                        if($warehouseId){
                            $this->setWarehouseObject($warehouseId,$warehouse);
                            return;
                        }
                    }
                    $warehouseId = $this->helper->getModel('Config\Warehouse')->getWarehouseForM2ePro($m2eOrder->getComponentMode());
                    if($warehouseId){
                        $this->setWarehouseObject($warehouseId,$warehouse);
                        return;
                    }
                }
            }
        }catch(\Exception $e) {
            /* log issue */
            $this->logger->log($e->getMessage(), 'OrderItemSaveAfter');
        }
    }
}