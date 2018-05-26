<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
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

    public function checkCredentials($inputData)
    {
        if (Auth::attempt([ 'email'=> $inputData['email'], 'password'  => $inputData['password'] ])) {
            return true;
        }

        return false;
    }

    public function getUser($inputData)
    {
        session(['isLoggedin' => false]);
        $model=User::where(['email'=>$inputData['email']])->select(['id','email','password'])->first();
        if (!$model) {
            return false;
        }


        if (Hash::check($inputData['password'], $model->password)) {
            session(['isLoggedin' => true]);
            return true;
            // Right password
        }
    }

    public function checkMobileNumber($inputData)
    {
        $model=User::where('mobile_number', $inputData['mobile_number'])->findOrFail(1);
        return $model;
    }
}
