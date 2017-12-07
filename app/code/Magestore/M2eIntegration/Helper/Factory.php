<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Helper;

class Factory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    //########################################

    /**
     * Construct
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    //########################################

    /**
     * @param string $helperName
     * @param array $arguments
     * @return \Magento\Framework\App\Helper\AbstractHelper
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getObject($helperName, array $arguments = [])
    {
        $helper = $this->objectManager->get('\Magestore\M2eIntegration\Helper\\'.$helperName, $arguments);
        if (!$helper) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __('%1 doesn\'t extends \Magento\Framework\App\Helper\AbstractHelper', $helperName)
            );
        }
        return $helper;
    }

    /**
     * @param string $modelName
     * @param array $arguments
     * @return mixed
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getModelObject($modelName, array $arguments = []){
        $model = $this->objectManager->create('\Magestore\M2eIntegration\Model\\'.$modelName);
        if (!$model) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __('%1 doesn\'t extends \Magento\Framework\Model\AbstractModel', $modelName)
            );
        }
        return $model;
    }

    //########################################
}
