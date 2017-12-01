<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class M2eOrderSuccess extends \Magestore\M2esuccess\Observer\M2esuccess
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
                if ($this->_coreRegistry->registry('os_m2e_order_create_before')) {
                    $this->_coreRegistry->unregister('os_m2e_order_create_before');
                }
            }
        }catch(\Exception $e) {
            /* log issue */
            $this->logger->log($e->getMessage(), 'm2eOrderSuccess');
        }
    }
}