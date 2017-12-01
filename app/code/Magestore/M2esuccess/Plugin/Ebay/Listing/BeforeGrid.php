<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Plugin\Ebay\Listing;

class BeforeGrid {

    public function afterCallbackColumnTitle(\Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Grid $grid, $type)
    {
       return [$grid];

    }

}
