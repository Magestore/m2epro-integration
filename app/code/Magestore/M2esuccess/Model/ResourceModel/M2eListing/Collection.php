<?php

namespace Magestore\M2esuccess\Model\ResourceModel\M2eListing;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{

    public function _construct()
    {
        $this->_init('Magestore\M2esuccess\Model\M2eListing', 'Magestore\M2esuccess\Model\ResourceModel\M2eListing');
    }
}