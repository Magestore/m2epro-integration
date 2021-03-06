<?php
/**
 *  Copyright © 2017 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\M2eIntegration\Model;

use Magento\Framework\Model\AbstractModel;

class M2eListing extends AbstractModel
{
    /**
     * @var \Magestore\InventorySuccess\Model\Warehouse
     */
    protected $warehousefactory;

    /**
     * M2eListing constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magestore\InventorySuccess\Model\Warehouse $warehouseProductFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->warehousefactory = $warehouseProductFactory;
    }

    /**
     * construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Magestore\M2eIntegration\Model\ResourceModel\M2eListing');
    }

    /**
     * @param int $listing_id
     * @param bool $returnId
     * @return mixed
     */
    public function getWarehouseByListing($listing_id,$returnId = false){
        $warehouse_id = $this->getCollection()->addFieldToFilter('listing_id',$listing_id)->getColumnvalues('warehouse_id');
        if($warehouse_id){
            $warehouse = $this->warehousefactory->getCollection()
                ->addFieldToFilter('warehouse_id',$warehouse_id['0'])
                ->getLastItem();
            if($returnId){
                return $warehouse->getId();
            }
            return $warehouse->getWarehouse();
        }
    }
}