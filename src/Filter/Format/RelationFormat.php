<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/8/15
 * Time: 5:02 PM
 */

namespace BugsLife\Criteria\Filter\Format;

/**
 * Class RelationFormat
 * 联表关联查询过滤
 * @package App\Libraries\Criteria\Filter\Format
 */
class RelationFormat extends Format
{
    /**
     * @var string // 关系配置键名
     */
    private $relationsKey = 'relations';

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
            if ($this->filterExists($index, $this->filterParams) && count($value) === 2) {
                $this->model = (new $value[1]())->filter($this->model, $this->filterParams[$index], $value[0]);
            }
        }
        return $this->model;
    }

}