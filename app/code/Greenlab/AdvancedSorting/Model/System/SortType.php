<?php

namespace Greenlab\AdvancedSorting\Model\System;

use Magento\Framework\Option\ArrayInterface;


class SortType implements ArrayInterface
{
    const BEST_SELLER  = "best_seller";
    const TOP_RATED = "top_rated";
    const NEW_ARRIVALS = "created_at";
    const MOST_VIEWED = "most_viewed";
    const REVIEW_COUNT = "review_count";

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getOptionHash() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * Return options
     *
     * @return array
     */
    public function getOptionHash()
    {
        return [
            self::BEST_SELLER  => __('Best Seller'),
            self::TOP_RATED => __('Top Rated'),
            self::NEW_ARRIVALS => __('New Arrivals'),
            self::MOST_VIEWED => __('Most Viewed'),
            self::REVIEW_COUNT => __('Review Count'),
        ];
    }
}
