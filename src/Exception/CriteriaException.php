<?php
/**
 * Created by PhpStorm.
 * User: Blue
 * Date: 2019/7/16
 * Time: 5:39 PM
 */

namespace BugsLife\criteria\Exception;


use Throwable;

/**
 * Class CriteriaException
 * 数据模型筛选数据构建模块异常处理
 * @package App\Libraries\Criteria\Exception
 */
class CriteriaException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}