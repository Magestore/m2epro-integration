<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Controller\Adminhtml\Ebay\Order;

use Ess\M2ePro\Controller\Adminhtml\Ebay\Order;

class UpdateShippingStatus extends Order
{
    /**
     * @return mixed
     */
    public function execute()
    {
        if ($this->processConnector(\Ess\M2ePro\Model\Ebay\Connector\Order\Dispatcher::ACTION_SHIP)) {
            $this->messageManager->addSuccess(
                $this->__('Shipping status for selected eBay Order(s) was updated to Shipped.')
            );
        } else {
            $this->messageManager->addError(
                $this->__('Shipping status for selected eBay Order(s) was not updated.')
            );
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }

    /**
     * @param $action
     * @param array $params
     * @return bool
     */
    protected function processConnector($action, array $params = array())
    {
        $ids = $this->getRequestIds();

        if (count($ids) == 0) {
            $this->messageManager->addError($this->__('Please select Order(s).'));
            return false;
        }
        /* m2e integration with Inventory_success*/
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $_moduleManager =    $objectManager->create('\Magento\Framework\Module\Manager');
        if($_moduleManager->isEnabled('Magestore_M2eIntegration')){
            $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
            $helper = $resource->getHelper('Data\Process');
            $helper->prepareOrderIdIntegrationWithInventory($this->getRequestIds());
        }
        /* end m2e integration with Inventory_success*/

        return $this->modelFactory->getObject('Ebay\Connector\Order\Dispatcher')->process(
            $action, $ids, $params
        );
    }

}