<?php

namespace Magestore\M2esuccess\Model\ResourceModel\M2eOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class M2eOrder extends AbstractCollection
{

    public function _construct()
    {
        $this->_init('Magestore\M2esuccess\Model\M2eOrder', 'Magestore\M2esuccess\Model\ResourceModel\M2eOrder');
    }
}