<?php

/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

namespace Magestore\M2eIntegration\Helper;

/**
 * Class Data
 * @package Magestore\M2eIntegration\Helper
 */
class Data
{
    /**
     * @var Factory
     */
    protected $magestoreHelperFactory;

    /**
     * @var \Ess\M2ePro\Helper\Factory
     */
    protected $m2eHelperFactory;
    /**
     * @var \Ess\M2ePro\Model\Factory
     */
    protected $m2eModelFactory;
    /**
     * @var \Ess\M2ePro\Model\ActiveRecord\Component\Parent\Amazon\Factory
     */
    protected $amazonFactory;

    /**
     * Data constructor.
     * @param Factory $magestoreHelperFactory
     * @param \Ess\M2ePro\Helper\Factory $m2eHelperFactory
     * @param \Ess\M2ePro\Model\Factory $m2eModelFactory
     * @param \Ess\M2ePro\Model\ActiveRecord\Component\Parent\Amazon\Factory $amazonFactory
     */
    public function __construct(
        \Magestore\M2eIntegration\Helper\Factory $magestoreHelperFactory
    )
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $moduleManager = $objectManager->create('\Magento\Framework\Module\Manager');
        $this->magestoreHelperFactory = $magestoreHelperFactory;
        if($moduleManager->isEnabled('Ess_M2ePro')){
            $this->m2eHelperFactory = $objectManager->create('\Ess\M2ePro\Helper\Factory');
            $this->m2eModelFactory = $objectManager->create('\Ess\M2ePro\Model\Factory');
            $this->amazonFactory = $objectManager->create('\Ess\M2ePro\Model\ActiveRecord\Component\Parent\Amazon\Factory');
        }
    }

    /**
     * @param string $helperName
     * @param array $arguments
     * @return \Magento\Framework\App\Helper\AbstractHelper
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getHelper($helperName, array $arguments = [])
    {
        return $this->magestoreHelperFactory->getObject($helperName, $arguments);
    }

    /**
     * @param string $modelName
     * @param array $arguments
     * @return mixed
     */
    public function getModel($modelName, array $arguments = [])
    {
        return $this->magestoreHelperFactory->getModelObject($modelName,$arguments);
    }

    /**
     * @param string $helperName
     * @param array $arguments
     * @return mixed
     */
    public function getM2eHelperFactory($helperName, array $arguments = []){
        return $this->m2eHelperFactory->getObject($helperName, $arguments);
    }

    /**
     * @param string $modelName
     * @param array $arguments
     * @return mixed
     */
    public function getM2eModelFactory($modelName, array $arguments = []){
        return $this->m2eModelFactory->getObject($modelName, $arguments);
    }

    /**
     * @return \Ess\M2ePro\Model\ActiveRecord\Component\Parent\Amazon\Factory
     */
    public function getAmazonFactory(){
        return $this->amazonFactory;
    }
}