<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/8/15
 * Time: 5:00 PM
 */

namespace BugsLife\criteria\Filter\Format;


use BugsLife\Criteria\Filter\ICriteria;
use BugsLife\Criteria\Exception\CriteriaException;

/**
 * Class Format
 *
 * @package App\Libraries\Criteria\Filter\Format
 */
abstract class Format implements ICriteria
{

    /**
     * @var // 请求参数
     */
    public $filterParams;

    /**
     * @var // 当前使用模型
     */
    protected $model;

    /**
     * @var array 请求参数敏感键名
     */
    protected $feeling = [
        'relations',
        'sort',
    ];

    /**
     * @var array 过滤器
     */
    protected $filter;

    /**
     * 获取当前模型过滤条件
     * @param $filter
     * @return array
     * @throws CriteriaException
     */
    public function getFilter($filter = null)
    {
        // 检测是否传递过滤条件
        $filter = $filter ?? $this->model->getModel()->filter;
        // 过滤条件是否设置验证
        if (! is_array($filter)) {
            throw new CriteriaException('BugsLife Criteria: No filtering rules set');
        }
        return $filter;
    }

    /**
     * 检查参数名称占用敏感问题
     * @param array $params
     * @return bool
     * @throws CriteriaException
     */
    public function feelingExists(array $params)
    {
        $paramKeys = array_keys($params);
        if (count(array_intersect($paramKeys, $this->feeling))) {
            throw new CriteriaException('BugsLife Criteria: Filter-sensitive keys in parameters');
        }
    }

    /**
     * 过滤条件是否存在
     * @param string/array $filter
     * @param array $param
     * @return bool
     */
    public function filterExists($filter, array $param)
    {
        return in_array($filter, array_keys($param))
            && isset($param[$filter])
            && ! is_null($param[$filter]);
    }

    /**
     * 初始化
     * @param $filerParams
     * @param $model
     * @param $filter
     * @return $this
     */
    public function boot($filerParams, $model, $filter = null)
    {
        $this->filterParams = $filerParams;
        $this->model = $model;
        // 检查参数名称占用敏感问题
        $this->feelingExists($this->filterParams);
        // 获取过滤器
        $this->filter = $this->getFilter($filter);

        return $this;
    }

    /**
     * 执行组装过滤器
     */
    public function doCriteria()
    {
        if (count($this->filter) > 0) {
            foreach ($this->filter as $key => $class) {
                // 执行组装过滤器
                $this->filter($key, $class);
            }
        }
        return $this->model;
    }


}