<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code]);
    }

    protected function showAll(Collection $collection, $code = 200) 
    {
        if($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        
        $transformer = $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);

        if($transformer) {
            return $this->successResponse($this->transformData($collection, $transformer), $code);    
        } else {
            return $this->successResponse(['data' => $collection], $code);
        }
         
    }

    protected function showOne(Model $instance, $code = 200)
    {
        if($transformer = $instance->transformer) {
            return $this->successResponse($this->transformData($instance, $transformer), $code);
        } else {
            return $this->successResponse(['data' => $instance], $code);
        }
    }

    protected function showMessage($message, $code = 200) 
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, $transformer) 
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if(request()->has('sort_by')) {
            $collection = $transformer ? $collection->sortBy->{$transformer::originalAttribute(request()->sort_by)} : $collection->sortBy->{request()->sort_by};
        }

        return $collection;
    }

    protected function filterData(Collection $collection, $transformer)
    {

        foreach(request()->query() as $query => $value) {
            $attribute = $transformer ? $transformer::originalAttribute($query) : $query;

            if(isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;

    } 
}

