<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Block\Adminhtml\Ebay\Listing\Create\General;

if(class_exists('\Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Create\General\Form')){
    class FormBase extends \Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Create\General\Form {}
}else{
    class FormBase {}
}

class Form extends FormBase
{

    protected function _prepareForm()
    {
        parent::_prepareForm();

        $storeId = '';
        $warehouseId = '';
        // ---------------------------------------
        $sessionKey = 'ebay_listing_create';
        $sessionData = $this->getHelper('Data\Session')->getValue($sessionKey);

        isset($sessionData['store_id'])       && $storeId = $sessionData['store_id'];
        isset($sessionData['warehouse_id'])   && $warehouseId = $sessionData['warehouse_id'];
        // ---------------------------------------

        $form = $this->getForm();
        /* integration Inventory with M2epro */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $magestoreHelper = $objectManager->create('Magestore\M2eIntegration\Helper\Data');
        $warehousefactory = $magestoreHelper->getHelper('Data\Warehouse');

        $fieldset = $form->addFieldset(
            'magestore_fieldset',
            [
                'legend' => $this->__('Warehouse'),
                'collapsable' => false
            ]
        );
        $fieldset->addField(
            'warehouse_switcher',
            self::SELECT,
            [
                'name' => 'warehouse_id',
                'label' => $this->__('Select Warehouse'),
                'value' => $warehouseId,
                'values' => $warehousefactory->getAllWarehouses(),
                'required' => false,
                'tooltip' => $this->__(
                    'Choose the Warehouse you want to use for this M2E Pro Listing.'
                )
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return $this;
    }

    //########################################
}