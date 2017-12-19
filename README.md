# criteria 筛选扩展
In your laravel project.Query conditions are often used.You don't have to write the query every time.
在你的laravel项目中，查询条件是经常使用的，每次都把where条件写一遍，感觉有点恶心，毕竟我比较懒。使用这个扩展后，你将不需要每次都写一遍查询条件。

## Installation
```
composer require bugslife/criteria:dev-dev
```
## Usage
use trait in your model and set $fieldSearchable,suport （=，like, between, >, <, >=, <=）,and && or,between request is [a, b].
```php
<?php

namespace App\Models;

use BugsLife\Criteria\Criteria;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use Criteria;

    protected $fillable = ['id', 'parent_id', 'name', 'intro', 'api_router', 'vue_router', 'state', 'sort', 'ico'];

    public $fieldSearchable = [
        'name' => ['=', 'and'],
        'intro' => ['like', 'or']
    ];

}
```
in your controller, use model and pushCriteria().
```php
   public function index(AdminMenu $menu)
    {
      return $menu->pushCriteria(\request())->orderBy('sort', 'asc')->paginate(10)
    }
```
