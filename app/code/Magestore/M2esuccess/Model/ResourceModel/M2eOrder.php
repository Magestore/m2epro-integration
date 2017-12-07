<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2esuccess\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class M2eOrder extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('os_m2e_order','id');
    }
}
