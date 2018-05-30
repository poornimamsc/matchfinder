<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\OtpRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\VerifyOtpRequest;


use App\Repositories\UserRepositorie;

class UserController extends BaseController
{
    public function getCaptcha(Request $request)
    {
        $request->session()->flush();
        session(['captcha' => "3TCJ"]);
        $response = [
                'status' => 1,
                'captcha_url'=>captcha_src("flat"),
                'data' => "Captcha Url",
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function sendOtp(OtpRequest $request, UserRepositorie $userRepo)
    {
        $request->session()->forget('captcha');
        
        $inputData = $request->all();
        if ($userRepo->checkMobileNumber($inputData['mobile_number'])) {
            $this->doOtp($inputData);
            $statusCode = 200;
            $response = array("data"=>"Data Sent","status"=>1);
        } else {
            $statusCode = 422;
            $response = array("data"=>"Mobile Number not exists","status"=>0);
        }
        
        
        return response()->json($response, $statusCode, [], JSON_PRETTY_PRINT);
    }

    
    public function showMessage(Request $request)
    {
        $response = array(
            "otp"=>session('otp'),
            "status"=>1,
            "number"=>session('mobile_number'),
            "captcha"=>session('captcha')
        );
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }


    public function create(CreateUserRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        try {
            $userRepo->createUser($inputData);
            $response = [
                'status' => 1,
                'data' => "Success"
            ];
            $request->session()->forget('captcha');
            $this->doOtp($inputData);
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "Error While Saving. Contact Customer Care!",
            ];
            \Log::debug('Create User Error.'.$e->getMessage());
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }


    public function userVerifcation(VerifyOtpRequest $request, UserRepositorie $userRepo)
    {
        $mobileNumber = session('mobile_number');
        $this->forgetKeys($request);
        try {
            $userRepo->activateUser($mobileNumber);
            $response = [
                'status' => 1,
                'data' => "Activated Successfully."
                ];
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "System Error. Contact Customer Care!",
            ];

            \Log::debug('Login Error.'.$e->getMessage());

            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }


    public function login(LoginRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        try {
            $res = $userRepo->getUser($inputData);
            $response = [
                'status' => $res['status'],
                'data' => $res['message'],
            ];
                
            return response()->json($response, $res['statusCode'], [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "System Error. Contact Customer Care!",
            ];

            \Log::debug('Login Error.'.$e->getMessage());

            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }


 

    public function resetPassword(UpdatePasswordRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        $mobileNumber = session('mobile_number');
        $this->forgetKeys($request);
        try {
            $userRepo->resetPassword($mobileNumber, $inputData['password']);
            $response = [
                'status' => 1,
                'data' => "Password Updated Successfully."
                ];
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "Password  Update Error. Contact Customer Care!",
            ];

            \Log::debug('Password Update Error.'.$e->getMessage());

            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $response = [
                'status' => 1,
                'data' => "Sucessfully logged out",
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    
    
    private function doOtp($inputData)
    {
        $code = str_random(5);
        session(['otp' => $code]);
        session(['mobile_number' => $inputData['mobile_number']]);
    }

    private function forgetKeys($request)
    {
        $request->session()->forget('mobile_number');
        $request->session()->forget('otp');
        $request->session()->forget('captcha');
    }

       
    /*
    public function resetOtp(OtpRequest $request)
    {
        $inputData = $request->all();
        $response = array("data"=>"Mobile number not found","status"=>0);
        $res = $userRepo->checkMobileNumber($inputData['mobile_number']);


        if ($res) {
            $this->doOtp($inputData);
            $response = array("data"=>"OTP Sent","status"=>1);
        }



        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }*/
}
