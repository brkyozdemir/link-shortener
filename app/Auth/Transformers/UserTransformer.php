<?php

namespace App\Auth\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
     public function transform(User $user): array
     {
         return [
             'id' => $user->id,
             'email' => $user->email,
             'name' => $user->name,
         ];
     }
}
