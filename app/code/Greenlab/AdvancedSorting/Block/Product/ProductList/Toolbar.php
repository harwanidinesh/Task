<?php

namespace Greenlab\AdvancedSorting\Block\Product\ProductList;


class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Set collection to sorting option
     *
     * @param \Magento\Framework\Data\Collection $collection
     *
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;
        $this->_collection->setCurPage($this->getCurrentPage());

        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }

        if ($this->getCurrentOrder()) {
            switch ($this->getCurrentOrder()) {
                case 'created_at':
                    $this->_collection->setOrder('created_at', $this->getCurrentDirectionReverse());
                    break;
                case 'best_seller':
                    $this->_collection->setOrder('best_seller', $this->getCurrentDirectionReverse());
                    break;
                case 'most_viewed':
                    $this->_collection->setOrder('top_rated', $this->getCurrentDirectionReverse());
                    break;
                default:
                    $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
                    break;
            }
        }

        return $this;
    }

    /**
     * Return Reverse direction of current direction
     *
     * @return string
     */
    public function getCurrentDirectionReverse()
    {
        if ($this->getCurrentDirection() == 'asc') {
            return 'desc';
        } elseif ($this->getCurrentDirection() == 'desc') {
            return 'asc';
        } else {
            return $this->getCurrentDirection();
        }
    }
}
