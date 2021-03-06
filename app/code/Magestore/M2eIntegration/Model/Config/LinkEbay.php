<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
/**
 * Order Statuses source model
 */
namespace Magestore\M2eIntegration\Model\Config;

class LinkEbay implements \Magento\Framework\Option\ArrayInterface
{
    /**
     *
     */
    const UNDEFINED_OPTION_LABEL = '-- Please Select --';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['value' => 1, 'label' => __('Global Website')];
        $options[] = ['value' => 2, 'label' => __('Specify Warehouse')];
        return $options;
    }
}
