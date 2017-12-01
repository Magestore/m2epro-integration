<?php

namespace Magestore\M2esuccess\Model;

use Magento\Framework\Model\AbstractModel;

class M2eOrder extends AbstractModel
{
    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Magestore\M2esuccess\Model\ResourceModel\M2eOrder');
    }

    /**
     * @param $id
     * @return bool
     */
    public function checkByM2eOrderId($id){
        $model = $this->getCollection()->addFieldToFilter('m2e_order_id',$id)->getLastItem();
        if($model){
            $check = $model->getId();
            if($check){
                return true;
            }
        }
        return false;
    }

}