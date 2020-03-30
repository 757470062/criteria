<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/7/16
 * Time: 11:22 AM
 */

namespace BugsLife\Criteria\Filter;

/**
 * Interface IFilter
 * 单表常规过滤器
 * @package App\Libraries\Criteria\Filter
 */
interface IFilter
{
    /**
     * 设置过滤条件
     * @param $entity // 数据模型绑定
     * @param $value // 传入的查询条件数据
     * @return mixed
     */
    public function filter($entity, $value);

}