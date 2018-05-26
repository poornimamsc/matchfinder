<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\LoginRequest;

use App\Repositories\UserRepositorie;

class ProfileController extends BaseController
{
    public function me()
    {
        $response = array("data"=>"About Me","status"=>1);
        return $response;
    }
}
