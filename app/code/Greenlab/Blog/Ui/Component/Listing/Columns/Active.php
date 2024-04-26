<?php 
/** 
* Copyright © 2013-2017 Magento, Inc. All rights reserved. 
* See COPYING.txt for license details. 
*/ 

namespace Greenlab\Blog\Ui\Component\Listing\Columns; 

use Magento\Framework\Data\OptionSourceInterface; 
use Magento\Framework\View\Element\UiComponentFactory; 
use Magento\Ui\Component\Listing\Columns\Column; 
use Magento\Framework\View\Element\UiComponent\ContextInterface; 

/** * Class Active */ 
class Active extends Column implements OptionSourceInterface 
{ 
    /** 
    * @param ContextInterface $context 
    * @param UiComponentFactory $uiComponentFactory 
    * @param StatusSource $source 
    * @param array $components 
    * @param array $data 
    */ 

    public function __construct( ContextInterface $context, 
        UiComponentFactory $uiComponentFactory, 
        array $components = [], 
        array $data = [] 
    ) { 
        parent::__construct($context, $uiComponentFactory, $components, $data); 
    } 

    /** * {@inheritdoc} */ 
    public function prepareDataSource(array $dataSource) 
    { 
        $dataSource = parent::prepareDataSource($dataSource); 
        $options = [ 1 => __('Yes'),
            2 => __('No')
        ];
 
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }
 
        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($options[$item['is_active']])) {
                $item['is_active'] = $options[$item['is_active']];
            }
        }
 
        return $dataSource;
    }
 
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $result = [];
        $result[] = ['value' => 1, 'label' => 'Yes'];
        $result[] = ['value' => 2, 'label' => 'No'];
 
        return $result;
    }
 
 
}
