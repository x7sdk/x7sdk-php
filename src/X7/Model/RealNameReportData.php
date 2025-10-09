<?php

namespace X7\Model;

use ReflectionProperty;

/**
 * 实名认证上报数据
 */
class RealNameReportData extends Model
{
    /**
     * 上报数据集合
     * 
     * @var RealNameCollection[]
     */
    public $collections = [];
    
    /**
     * 构造方法
     * 
     * @param array $collections 上报数据集合
     */
    public function __construct(array $collections = [])
    {
        foreach ($collections as $collection) {
            if ($collection instanceof RealNameCollection) {
                $this->collections[] = $collection;
            } else if (is_array($collection)) {
                $this->collections[] = RealNameCollection::make($collection);
            }
        }
    }
    
    /**
     * 添加上报数据项
     * 
     * @param RealNameCollection|array $collection 上报数据项
     * @return void
     */
    public function addCollection($collection)
    {
        if ($collection instanceof RealNameCollection) {
            $this->collections[] = $collection;
        } else if (is_array($collection)) {
            $this->collections[] = RealNameCollection::make($collection);
        }
    }
    
    /**
     * 转换为数组
     * 
     * @return array
     */
    public function toArray($filter = ReflectionProperty::IS_PUBLIC)
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->toArray();
        }
        
        return [
            'collections' => $collections
        ];
    }
}