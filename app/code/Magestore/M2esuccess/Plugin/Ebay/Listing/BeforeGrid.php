<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2esuccess\Plugin\Ebay\Listing;

class BeforeGrid {
    /**
     * @param \Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Grid $grid
     * @param $type
     * @return array
     */
    public function afterCallbackColumnTitle(\Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Grid $grid, $type)
    {
       return [$grid];

    }

}
