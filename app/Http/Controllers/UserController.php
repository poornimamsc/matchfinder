<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\OtpRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UpdatePasswordRequest;


use App\Repositories\UserRepositorie;

class UserController extends BaseController
{
    public function getMessage(OtpRequest $request)
    {
        $inputData = $request->all();
        $this->doOtp($inputData);
        $response = array("data"=>"Data Sent","status"=>1);
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function showMessage(Request $request)
    {
        $response = array("data"=>session('otp'),"status"=>1,"number"=>session('mobile_number'));
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
            $this->forgetOtp($request);
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "Error While Saving....",
            ];
            \Log::debug('Create User Error.'.$e->getMessage());
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function login(LoginRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        try {
            $res = $userRepo->getUser($inputData);
            
            if ($res) {
                $response = [
                'status' => 1,
                'data' => "Success"
                ];
            } else {
                $response = [
                'status' => 0,
                'data' => "Invlaid Login Details ..."
                ];
            }
            
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => "Invlaid Login Details....",
            ];

            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function resetOtp(OtpRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        $response = array("data"=>"Mobile number not found","status"=>0);
        $res = $userRepo->checkMobileNumber($inputData);
        
        if ($res) {
            $this->doOtp($inputData);
            $response = array("data"=>"OTP Sent","status"=>1);
        }
        
        
        
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function resetPassword(UpdatePasswordRequest $request, UserRepositorie $userRepo)
    {
        $inputData = $request->all();
        $this->forgetOtp($request);
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

    private function forgetOtp($request)
    {
        $request->session()->forget('mobile_number');
        $request->session()->forget('otp');
    }
}
