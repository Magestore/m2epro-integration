<?php


namespace Magestore\M2esuccess\Helper;

class Factory
{
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
     * @param $helperName
     * @param array $arguments
     * @return \Magento\Framework\App\Helper\AbstractHelper
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getObject($helperName, array $arguments = [])
    {
        $helper = $this->objectManager->get('\Magestore\M2esuccess\Helper\\'.$helperName, $arguments);
        if (!$helper) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __('%1 doesn\'t extends \Magento\Framework\App\Helper\AbstractHelper', $helperName)
            );
        }
        return $helper;
    }

    /**
     * @param $modelName
     * @param array $arguments
     * @return mixed
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function getModelObject($modelName, array $arguments = []){
        $model = $this->objectManager->create('\Magestore\M2esuccess\Model\\'.$modelName);
        if (!$model) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __('%1 doesn\'t extends \Magento\Framework\Model\AbstractModel', $modelName)
            );
        }
        return $model;
    }

    //########################################
}
