<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/8/15
 * Time: 4:56 PM
 */

namespace BugsLife\criteria\Filter;

/**
 * Interface ICriteria
 * @package App\Libraries\Criteria\Filter
 */
interface ICriteria
{
    /**
     * 处理过滤
     * @param $key // 过滤器键与请求参数匹配
     * @param $class // 使用的过滤器类
     * @param array $extends // 扩展参数 ['params1' => 1, ]
     * @return mixed
     */
    public function filter($key, $class, $extends = []);

}