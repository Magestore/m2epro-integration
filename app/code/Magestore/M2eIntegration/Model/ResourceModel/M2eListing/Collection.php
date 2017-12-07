<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Model\ResourceModel\M2eListing;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{

    public function _construct()
    {
        $this->_init('Magestore\M2eIntegration\Model\M2eListing', 'Magestore\M2eIntegration\Model\ResourceModel\M2eListing');
    }
}