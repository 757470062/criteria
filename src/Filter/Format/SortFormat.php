<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2020/3/30
 * Time: 11:38 AM
 */

namespace BugsLife\Criteria\Filter\Format;

/**
 * Class SortFormat
 * Filed sort.
 * @package App\Libraries\Criteria\Filter\Format
 */
class SortFormat extends Format
{

    /**
     * @var string // 关系配置键名
     */
    private $relationsKey = 'sort';

    public function __construct()
    {
        // 设置敏感键名
        $this->feeling = [$this->relationsKey];
    }

    /**
     * 处理过滤
     * @param $key // 过滤器键与请求参数匹配
     * @param $class // 使用的过滤器类
     * @param array $extends // 扩展参数 ['params1' => 1, ]
     * @return mixed
     */
    public function filter($key, $class, $extends = [])
    {
        // 非关系查询
        if (strcmp($key, $this->relationsKey) !== 0) {
            return $this;
        }
        foreach ($class as $index => $value) {
            if ($this->filterExists($index, $this->filterParams)) {
                $this->model = (new $value())->filter($this->model, $this->filterParams[$index]);
            }
        }
        return $this->model;
    }
}