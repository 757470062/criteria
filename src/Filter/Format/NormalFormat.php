<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/8/15
 * Time: 5:04 PM
 */

namespace BugsLife\Criteria\Filter\Format;

/**
 * Class NormalFormat
 * 常规查询过滤
 * @package App\Libraries\Criteria\Filter\Format
 */
class NormalFormat extends Format
{
    /**
     * 处理过滤
     * @param $key
     * @param $class
     * @param $extends
     * @return mixed
     */
    public function filter($key, $class, $extends = [])
    {
        if (in_array($key, $this->feeling)) {
            return $this;
        }
        // 非关系查询
        if ($this->filterExists($key, $this->filterParams)) {
            $this->model = (new $class())->filter($this->model, $this->filterParams[$key]);
        }
        return $this->model;
    }

}