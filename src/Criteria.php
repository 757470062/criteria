<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/7/16
 * Time: 2:04 PM
 */

namespace BugsLife\criteria;

use BugsLife\Criteria\Exception\CriteriaException;
use BugsLife\Criteria\Filter\Format\NormalFormat;
use BugsLife\Criteria\Filter\Format\RelationFormat;
use BugsLife\Criteria\Filter\Format\SortFormat;

/**
 * Class Criteria
 * 数据模型筛选数据构建。
 * ------------------------------------------------------------------------------------------
 * 请求参数必须保持与filter的名称一直；
 * ------------------------------------------------------------------------------------------
 * 默认在所属model对象中配置$filter变量,类型为数组；使用统一过滤器全局常量无需传递次变量.
 * 使用过滤器必须初始化$filter变量
 * 如：public $filter = ['title' => TitleFilter::class,'content' => ContentFilter::class];
 * ------------------------------------------------------------------------------------------
 * 一个模型存在多个filter的情况:可定义多个filter变量并自行选择参与筛选的过滤器.
 * -------------------------------------------------------------------------------------------
 * 过滤器检测到参数(param)中并未携带的过滤条件,但是filter中已经设置，这种情况过滤器会忽略掉此条件，不参与过滤.
 * @package App\Libraries\Repository\Criteria
 */
trait Criteria
{

    private $format = [
        'normal' => NormalFormat::class,
        'relation' => RelationFormat::class,
        'sort' => SortFormat::class,
    ];

    /**
     * @param array $param
     * @param null $filter
     * @return mixed
     * @throws CriteriaException
     */
    public function withCriteria(array $param, $filter = null)
    {
        $model = '';
        foreach ($this->format as $name => $class) {
            $model = (new $class)
                ->boot($param, $this->model, $filter)
                ->doCriteria();
        }
        return $model;
    }

}
