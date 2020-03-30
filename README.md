# criteria 筛选扩展
在你的laravel项目中，查询条件是经常使用的，每次都把where条件写一遍，感觉有点恶心，毕竟我比较懒。使用这个扩展后，你将不需要每次都写一遍查询条件。

## Installation
```
composer require bugslife/criteria
```
## Usage
1.访问链接示例:http://host/common/v1/common/code?name=A&order_by_sort=asc&order_by_id=desc

2. 服务层

```php
<?php
namespace App\Service;

use BugsLife\Criteria\Criteria;

/**
 * Class Service
 * @package App\Service
 */
class CodeService
{
    use Criteria;
    
    public function __construct(Code $code)
    {
        $this->model = $code;
    }

    /**
     * @var //模型
     */
    public $model;

    /**
     * 获取分页数据
     * @return mixed
     */
    public function paginate()
    {
        return $this->withCriteria(request()->all())->paginate();
    }
}
```
3.控制器.

```php
<?php

namespace App\Http\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Service\CodeService;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    private $service;

    public function __construct(CodeService $service)
    {
        $this->service = $service;
    }

    /**
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
       dd($this->service->paginate());
    }
}
```
4.模型

```php
<?php

namespace App\Models;

use App\Filters\NameEqualFilter;
use App\Filters\OrderByIdFilter;
use App\Filters\OrderBySortFilter;


/**
 * Class Code
 * 标准码模型
 * @package App\Models
 */
class Code extends BaseModel
{
    protected $fillable = ['application_id', 'key', 'name', 'sort'];

    public $filter = [
        'name' => NameEqualFilter::class,
        'relations' => [ // 关联关系过滤器使用枚举
            'major_type' => ['bidProject', BidInviteHasOneProjectMajorTypeEqualFilter::class],
            //'join_status' => ['bidJoin', BidInviteHasOneBidJoinStatusEqualFilter::class],
        ],
        'sort' => [
            'order_by_sort' => OrderBySortFilter::class,
            'order_by_id' => OrderByIdFilter::class
        ]
    ];

}
```

5.过滤器示例.

单表查询

```php
<?php

namespace App\Filters;

use BugsLife\Criteria\Filter\IFilter;


/**
 * Class NameEqualFilter
 * 名称相等过滤：sql = 'name = "值"'
 * @package App\Filters
 */
class NameEqualFilter implements IFilter
{


    /**
     * 设置过滤条件
     * @param $entity // 数据模型绑定
     * @param $value // 传入的查询条件数据
     * @return mixed
     */
    public function filter($entity, $value)
    {
        return $entity->where('name', '=', $value); // =
        return $entity->whereIn('bid_invite_id', $value); // in
        return $entity->orderBy('id', $value);// order By
    }
}
```

查询数据表关联过滤器

```php
<?php

namespace App\Http\Filter\Relations;


use App\Libraries\Criteria\Filter\IFilter;
use App\Libraries\Criteria\Filter\IFilterRelation;

/**
 * Class BidInviteHasOneBidJoinStatusEqualFilter.php
 * 投标类型联合查询过去器
 * @package App\Http\Filter\Relations
 */
class BidInviteHasOneBidJoinStatusEqualFilter implements IFilterRelation
{

    /**
     * 设置过滤条件
     * @param $entity // 数据模型绑定
     * @param $value // 传入的查询条件数据
     * @param $relation // 创建关系
     * @return mixed
     */
    public function filter($entity, $value, $relation)
    {
        return $entity->whereHas($relation, function ($query) use ($value) {
            return $query->Where('status', $value);
        });
    }
}
```

