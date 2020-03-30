<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/8/16
 * Time: 9:55 AM
 */

namespace BugsLife\Criteria\Filter;

/**
 * Interface IFilterRelation
 * 多表联合查询过滤器
 * @package App\Libraries\Criteria\Filter
 */
interface IFilterRelation
{
    /**
     * 设置过滤条件
     * @param $entity // 数据模型绑定
     * @param $value // 传入的查询条件数据
     * @param $relation // 创建的关系
     * @return mixed
     */
    public function filter($entity, $value, $relation);
}