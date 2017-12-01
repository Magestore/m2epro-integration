<?php

/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\M2esuccess\Helper;

/**
 * Class Data
 * @package Magestore\M2esuccess\Helper
 */
class Data
{
    /**
     * @var Factory
     */
    protected $magestoreHelperFactory;

    protected $m2eHelperFactory;
    protected $m2eModelFactory;

    protected $amazonFactory;
    /**
     * Data constructor.
     * @param Factory $magestoreHelperFactory
     */
    public function __construct(
        \Magestore\M2esuccess\Helper\Factory $magestoreHelperFactory,
        \Ess\M2ePro\Helper\Factory $m2eHelperFactory,
        \Ess\M2ePro\Model\Factory $m2eModelFactory,
        \Ess\M2ePro\Model\ActiveRecord\Component\Parent\Amazon\Factory $amazonFactory
    )
    {
        $this->magestoreHelperFactory = $magestoreHelperFactory;
        $this->m2eHelperFactory = $m2eHelperFactory;
        $this->m2eModelFactory = $m2eModelFactory;
        $this->amazonFactory = $amazonFactory;
    }

    /**
     * @param $helperName
     * @param array $arguments
     * @return \Magento\Framework\App\Helper\AbstractHelper
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getHelper($helperName, array $arguments = [])
    {
        return $this->magestoreHelperFactory->getObject($helperName, $arguments);
    }

    /**
     * @param $modelName
     * @param array $arguments
     * @return mixed
     */
    public function getModel($modelName, array $arguments = [])
    {
        return $this->magestoreHelperFactory->getModelObject($modelName,$arguments);
    }

    /**
     * @param $helperName
     * @param array $arguments
     * @return mixed
     */
    public function getM2eHelperFactory($helperName, array $arguments = []){
        return $this->m2eHelperFactory->getObject($helperName, $arguments);
    }

    public function getM2eModelFactory($helperName, array $arguments = []){
        return $this->m2eModelFactory->getObject($helperName, $arguments);
    }
    
    public function getAmazonFactory(){
        return $this->amazonFactory;
    }
}