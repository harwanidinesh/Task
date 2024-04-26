<?php 
/** * Copyright © 2013-2017 Magento, Inc. All rights reserved. 
* See COPYING.txt for license details. */ 

namespace Greenlab\Blog\Ui\DataProvider\Product; 

use Magento\Framework\App\RequestInterface; 
use Magento\Ui\DataProvider\AbstractDataProvider; 
use Greenlab\Blog\Model\ResourceModel\Post\CollectionFactory; 
use Greenlab\Blog\Model\ResourceModel\Post\Collection; 
use Greenlab\Blog\Model\Post; 

/** * Class CustomDataProvider * 
    * @method Collection getCollection 
*/ 

class CustomDataProvider extends AbstractDataProvider 
{ 
    /** * @var CollectionFactory */ 
    protected $collectionFactory; 
    /** * @var RequestInterface */ 
    protected $request; 
    /** * @param string $name 
    * @param string $primaryFieldName 
    * @param string $requestFieldName 
    * @param CollectionFactory $collectionFactory 
    * @param RequestInterface $request 
    * @param array $meta 
    * @param array $data 
    */ 
    public function __construct( $name, 
        $primaryFieldName, 
        $requestFieldName, 
        CollectionFactory $collectionFactory, 
        RequestInterface $request, 
        array $meta = [], 
        array $data = [] 
    ) { 
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data); 
        $this->collectionFactory = $collectionFactory;
        $this->collection = $this->collectionFactory->create();
        $this->request = $request;
    }
 
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->getCollection()->addEntityFilter($this->request->getParam('current_product_id', 0));
       
        $arrItems = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => [],
        ];
 
        foreach ($this->getCollection() as $item) {
            $arrItems['items'][] = $item->toArray([]);
        }
 
        return $arrItems;
    }
 
    /**
     * {@inheritdoc}
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        $field = $filter->getField();
 
        if (in_array($field, ['post_id','title','creation_time', 'is_active'])) {
            $filter->setField($field);
        }
 
 
 
        parent::addFilter($filter);
    }
}
