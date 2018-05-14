<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepositorie
{
    /**
     * @param $keyword
     * @return array|string
     */
    public function createUser($inputData)
    {
        $attributes['name'] = $inputData['username'];
        $attributes['email'] = $inputData['email'];
        $attributes['mobile_number'] = $inputData['mobile_number'];
        $attributes['password'] = Hash::make($inputData['password']);
        $model = User::create($attributes);
    }

    public function getUser($inputData)
    {

    	$model=User::where(['email'=>$inputData['email']])->select(['id','email','password'])->first();
        if(!$model)
            return false;


        if(Hash::check($inputData['password'],$model->password)) {
            return true;
            // Right password
        }

    }
}
