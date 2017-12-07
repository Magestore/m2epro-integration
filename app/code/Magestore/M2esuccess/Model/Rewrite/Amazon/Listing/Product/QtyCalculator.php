<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

/**
 * @method \Ess\M2ePro\Model\Amazon\Listing getComponentListing()
 * @method \Ess\M2ePro\Model\Amazon\Template\SellingFormat getComponentSellingFormatTemplate()
 * @method \Ess\M2ePro\Model\Amazon\Listing\Product getComponentProduct()
 */
namespace Magestore\M2esuccess\Model\Rewrite\Amazon\Listing\Product;

class QtyCalculator extends \Magestore\M2esuccess\Model\Rewrite\Listing\Product\QtyCalculator
{
    /**
     * @var bool
     */
    private $isMagentoMode = false;

    //########################################

    /**
     * @param bool $value
     * @return \Ess\M2ePro\Model\Amazon\Listing\Product\QtyCalculator
     */
    public function setIsMagentoMode($value)
    {
        $this->isMagentoMode = (bool)$value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function getIsMagentoMode()
    {
        return $this->isMagentoMode;
    }

    //########################################

    public function getProductValue()
    {
        if ($this->getIsMagentoMode()) {
            return (int)$this->getMagentoProduct()->getQty(true);
        }

        return parent::getProductValue();
    }

    protected function getOptionBaseValue(\Ess\M2ePro\Model\Listing\Product\Variation\Option $option)
    {
        if ($this->getIsMagentoMode() ||
            $this->getSource('mode') == \Ess\M2ePro\Model\Template\SellingFormat::QTY_MODE_PRODUCT) {

            if (!$this->getMagentoProduct()->isStatusEnabled() ||
                !$this->getMagentoProduct()->isStockAvailability()) {
                return 0;
            }
        }

        if ($this->getIsMagentoMode()) {
            return (int)$option->getMagentoProduct()->getQty(true);
        }

        return parent::getOptionBaseValue($option);
    }

    //########################################

    protected function applySellingFormatTemplateModifications($value)
    {
        if ($this->getIsMagentoMode()) {
            return $value;
        }

        return parent::applySellingFormatTemplateModifications($value);
    }

    //########################################
}