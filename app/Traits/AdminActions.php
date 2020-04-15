<?php 

namespace App\Traits;

trait AdminActions
{
    public function before($user, $ability)
    {
        return true;
    }

}

