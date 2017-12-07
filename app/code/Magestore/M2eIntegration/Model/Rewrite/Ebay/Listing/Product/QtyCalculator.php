<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

/**
 * @method \Ess\M2ePro\Model\Ebay\Listing getComponentListing()
 * @method \Ess\M2ePro\Model\Ebay\Template\SellingFormat getComponentSellingFormatTemplate()
 * @method \Ess\M2ePro\Model\Ebay\Listing\Product getComponentProduct()
 */
namespace Magestore\M2eIntegration\Model\Rewrite\Ebay\Listing\Product;

class QtyCalculator extends \Magestore\M2eIntegration\Model\Rewrite\Listing\Product\QtyCalculator
{
    //########################################

    public function getVariationValue(\Ess\M2ePro\Model\Listing\Product\Variation $variation)
    {
        if ($variation->getChildObject()->isDelete()) {
            return 0;
        }

        return parent::getVariationValue($variation);
    }

    //########################################

    protected function getOptionBaseValue(\Ess\M2ePro\Model\Listing\Product\Variation\Option $option)
    {
        if (!$option->getMagentoProduct()->isStatusEnabled() ||
            !$option->getMagentoProduct()->isStockAvailability()) {
            return 0;
        }

        if ($this->getSource('mode') == \Ess\M2ePro\Model\Template\SellingFormat::QTY_MODE_PRODUCT) {

            if (!$this->getMagentoProduct()->isStatusEnabled() ||
                !$this->getMagentoProduct()->isStockAvailability()) {
                return 0;
            }
        }

        return parent::getOptionBaseValue($option);
    }

    //########################################
}