<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        
    }

    protected function findModelItem(HasMany $collection, $value): Model
    {

        $instance = $collection->find($value);

        if(is_null($instance)) {
            $exception = new ModelNotFoundException();
            $exception->setModel($collection->getRelated());
            throw $exception;
        }

        return $instance;

    }
 
}
