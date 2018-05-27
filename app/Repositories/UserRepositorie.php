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
        $model=User::where(['email'=>$inputData['email']])->select(['id','email','password','status'])->first();
        $response = ["status"=>0, "statusCode"=> 422, "message"=>"Invalid login details"];

        if (!$model || !Hash::check($inputData['password'], $model->password)) {
            return $response;
        }

        switch ($model->status) {
            
            case 0:
                $response = ["status"=> 0, "statusCode"=> 422, "message"=>"Please activate your account"];
            break;
            
            case 1:
                session(['isLoggedin' => true]);
                $response = ["status"=> 1, "statusCode"=> 200, "message"=>"Login Success"];
            break;

            case 2:
                $response = ["status"=> 2, "statusCode"=> 422, "message"=>"Your account is locked."];
            break;


        }
        return $response;
    }

    public function checkMobileNumber($mobileNumber)
    {
        return User::where('mobile_number', $mobileNumber)->exists();
    }

    public function activateUser($mobileNumber)
    {
        User::where('mobile_number', $mobileNumber)
              ->update(['status' => 1]);
    }

    public function resetPassword($mobileNumber, $password)
    {
        User::where('mobile_number', $mobileNumber)
              ->update(['password' => Hash::make($password)]);
    }
}
