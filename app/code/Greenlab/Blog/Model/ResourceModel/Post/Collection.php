<?php

namespace Greenlab\Blog\Model\ResourceModel\Post;

use Greenlab\Blog\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'bf_blog_post_collection';
    protected $_eventObject = 'bf_blog_post_collection';
    protected $flagStoreFilter = false;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Greenlab\Blog\Model\Post', 'Greenlab\Blog\Model\ResourceModel\Post');
    }

    public function joinCategoryColumn()
    {
        $this->addFilterToMap('post_id', 'main_table.post_id');
    }

    public function joinTagColumn()
    {
        $this->addFilterToMap('post_id', 'main_table.post_id');
    }
    

    /**
     * Add entity filter
     *
     * @param int|string $entity
     * @param int $pkValue
     * @return $this
     */
    public function addEntityFilter($entity)
    {
            $this->_select->joinLeft(
            ['post_product' => $this->getTable('bf_blog_post_product')],
            'main_table.post_id = post_product.post_id',
            'product_id'
        )->where("post_product.product_id = ".$entity);

        return $this;
    }
}
