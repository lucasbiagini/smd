<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class GetUserSetoresController extends Controller
{
    public function __invoke (User $user)
    {
        return $user->setores()->where('status', 1)->get();
    }
}
