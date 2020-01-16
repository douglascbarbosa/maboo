<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'creationDate' => (string)$user->created_at,
            'lastChange' => (string)$user->updated_at,
            
        ];
    }

    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',            
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
