<?php

namespace BugsLife\Criteria;


trait Criteria
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

                    if ((strcasecmp($condition[0], '=') !== 0 && strcasecmp($condition[0], 'like') !== 0) && !is_array($value)){
                        throw new \Exception(__METHOD__.':'.'use [ '.$condition[0].' ] select field. So [ '.$field.' ] must be array()');
                    }

                    if (strcasecmp($condition[0], 'like') === 0){
                        $value = '%'. $request[$field] .'%';
                    }

                    if (strcasecmp($condition[1], 'and') === 0){
                        if($isFirstField || strcasecmp($condition[0], '=') === 0 || strcasecmp($condition[0], 'like') === 0){
                            $query->where($field, $condition[0], $value);
                            $isFirstField = false;
                        }else if (strcasecmp($condition[0], 'between') === 0){
                            $query->whereBetween($field, $value);
                        }else if (strcasecmp($condition[0], 'notBetween') === 0){
                            $query->whereNotBetween($field, $value);
                        }else if (strcasecmp($condition[0], 'in') === 0){
                            $query->whereIn($field, $value);
                        }else if (strcasecmp($condition[0], 'notIn') === 0){
                            $query->whereNotIn($field, [$value]);
                        }
                    }else{
                        if(strcasecmp($condition[0], '=') === 0 || strcasecmp($condition[0], 'like') === 0){
                            $query->orWhere($field, $condition[0], $value);
                        }else if (strcasecmp($condition[0], 'between') === 0){
                            $query->orWhereBetween($field, $value);
                        }else if (strcasecmp($condition[0], 'notBetween') === 0){
                            $query->orWhereNotBetween($field, $value);
                        }else if (strcasecmp($condition[0], 'in') === 0){
                            $query->orWhereIn($field, [$value]);
                        }else if (strcasecmp($condition[0], 'notIn') === 0){
                            $query->orWhereNotIn($field, [$value]);
                        }
                    }
                }
            }

        });
        return $model;
    }
}
