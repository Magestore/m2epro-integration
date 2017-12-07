<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class M2eOrderFail extends \Magestore\M2eIntegration\Observer\M2esuccess
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
     * M2eOrderFail constructor.
     * @param \Magestore\InventorySuccess\Api\Logger\LoggerInterface $logger
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magestore\M2eIntegration\Helper\Data $helper
     */
    public function __construct(
        \Magestore\InventorySuccess\Api\Logger\LoggerInterface $logger,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magestore\M2eIntegration\Helper\Data $helper
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
                if ($this->_coreRegistry->registry('os_m2e_order_create_before')) {
                    $this->_coreRegistry->unregister('os_m2e_order_create_before');
                }
            }
        }catch(\Exception $e) {
            /* log issue */
            $this->logger->log($e->getMessage(), 'm2eOrderFail');
        }
    }
}