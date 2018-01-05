<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Controller\Adminhtml\Amazon\Order;

use Ess\M2ePro\Controller\Adminhtml\Amazon\Order;

class UpdateShippingStatus extends \Ess\M2ePro\Controller\Adminhtml\Amazon\Order\UpdateShippingStatus
{
    public function execute()
    {
        $ids = $this->getRequestIds();
        if (count($ids) != 0) {
            /* m2e integration with Inventory_success*/
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $_moduleManager =    $objectManager->create('\Magento\Framework\Module\Manager');
            if($_moduleManager->isEnabled('Magestore_M2eIntegration')){
                $resource = $objectManager->get('Magestore\M2eIntegration\Helper\Data');
                $helper = $resource->getHelper('Data\Process');
                $helper->prepareOrderIdIntegrationWithInventory($ids);
            }
            /* end m2e integration with Inventory_success*/
        }

        return parent::execute();
    }
}