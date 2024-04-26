<?php

namespace Greenlab\AdvancedSorting\Plugin;

use Greenlab\AdvancedSorting\Model\System\SortType;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;


class AddSortOption extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * StoreManager
     *
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     * SortType
     *
     * @var array
     */
    public $SortType;

    /**
     * AddSortOption constructor.
     *
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     * @param SortType              $SortType
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        SortType $SortType
    ) {
        $this->storeManager = $storeManager;
        $this->SortType = $SortType->toOptionArray();
        parent::__construct($context);
    }

    /**
     * Add sort order option created_at to frontend
     *
     * @param \Magento\Catalog\Model\Config $configmodel
     * @param array                         $options
     *
     * @return mixed
     */
    public function afterGetAttributeUsedForSortByArray($configmodel, $options)
    {
        $isEnabled = $this->scopeConfig->getValue(
            'sparshadvancedsorting/general/enabled',
            ScopeInterface::SCOPE_STORE,
            null
        );

        if ($isEnabled) {
            $SortByList = $this->scopeConfig->getValue(
                'sparshadvancedsorting/general/selectsort',
                ScopeInterface::SCOPE_STORE,
                null
            );

            foreach ($this->SortType as $optionlist) {
                if (isset($options[$optionlist['value']])) {
                    unset($options[$optionlist['value']]);
                }
            }

            unset($options['created_at']);

            foreach (explode(',', $SortByList) as $items) {
                foreach ($this->SortType as $optionlist) {
                    if (in_array($items, $optionlist)) {
                        $options[$optionlist['value']] = $optionlist['label']->getText();
                    }
                }
            }
        }

        return $options;
    }
}
