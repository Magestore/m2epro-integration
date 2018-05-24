<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Controller\Adminhtml\Ebay\Order;

if(class_exists('\Ess\M2ePro\Controller\Adminhtml\Ebay\Order\UpdateShippingStatus')){
    class UpdateShippingStatusBase extends \Ess\M2ePro\Controller\Adminhtml\Ebay\Order\UpdateShippingStatus {}
}else{
    class UpdateShippingStatusBase {}
}

class UpdateShippingStatus extends UpdateShippingStatusBase
{

    /**
     * @param $action
     * @param array $params
     * @return bool
     */
    protected function processConnector($action, array $params = array())
    {
        $ids = $this->getRequestIds();
        if (count($ids) != 0) {
            /* m2e integration with Inventory_success*/
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $_moduleManager = $objectManager->create('\Magento\Framework\Module\Manager');
            if ($_moduleManager->isEnabled('Magestore_M2eIntegration')) {
                $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
                $helper = $resource->getHelper('Data\Process');
                $helper->prepareOrderIdIntegrationWithInventory($ids);
            }
        }
        return parent::processConnector($action, $params = array());
    }
}