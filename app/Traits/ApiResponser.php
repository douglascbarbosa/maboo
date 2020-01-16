<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

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
        $collection = $this->paginate($collection);

        if($transformer) {
            $collection = $this->transformData($collection, $transformer);
        }

        $this->cacheResponse($collection);

        return $this->successResponse(['data' => $collection], $code);
         
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
        $instance = $collection->first();

        foreach(request()->query() as $query => $value) {
            $attribute = $transformer ? $transformer::originalAttribute($query) : $query;

            if(isset($attribute, $value) && Schema::hasColumn($instance->getTable(), $attribute)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;

    } 

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = request()->has('per_page') ? (int)request()->per_page : 15;

        $results = $collection->slice(($page -1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $url = "{$url}?{$queryString}";

        return Cache::remember($url, 30/60, function() use($data) {
            return $data;
        });
    }
}

