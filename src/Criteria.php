<?php
/**
 * Created by PhpStorm.
 * User: huangangui
 * Date: 2017/12/20
 * Time: 上午1:13
 */

namespace packages\bugslife\criteria\src;


class Criteria
{

    /**
     * support（=，like, between, >, <, >=, <=, between)
     * @param $request
     * @return mixed
     */
    public function pushCriteria($request){

        $model = $this;

        $isFirstField = true;

        $fieldSearchable = $model->fieldSearchable;

        $model = $model->where(function ($query) use ($request, $fieldSearchable, $isFirstField){
            foreach ($fieldSearchable as $field => $condition){
                if (!is_null($request[$field])){
                    $value = $request[$field];
                    if (strcasecmp($condition[0], 'like') === 0){
                        $value = '%'. $request[$field] .'%';
                    }
                    if (($isFirstField || strcasecmp($condition[1], 'and') === 0) && !strcasecmp($condition[1], 'between') === 0){
                        $query->where($field, $condition[0], $value);
                        $isFirstField = false;
                    }else if (strcasecmp($condition[1], 'between') === 0){
                        $query->whereBetween($field, $value);
                    }else{
                        $query->orWhere($field, $condition[0], $value);
                    }
                }
            }

        });
        return $model;
    }
}