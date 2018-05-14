<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\OtpRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;

use App\Repositories\UserRepositorie;


class UserController extends BaseController
{

    
    function getMessage(OtpRequest $request)
    {
    	$code = str_random(5);
    	session(['otp' => $code]);
    	$response = array("data"=>"Data Sent".$code,"status"=>1);
    	return $response;
    }

    function showMessage(Request $request)
    {
    	$response = array("data"=>session('otp'),"status"=>1);
    	return $response;
    }


    function create(CreateUserRequest $request, UserRepositorie $userRepo)
    {
    	$inputData = $request->all();
    	try {
	    	$userRepo->createUser($inputData);
	    	$response = [
	            'status' => 1,
	            'data' => "Success"
	        ];

	        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    	}catch(\Exception $e){
    		$response = [
	            'status' => 0,
	            'data' => "Error While Saving....",
	        ];

    		return response()->json($response, 500, [], JSON_PRETTY_PRINT);
    	}

    }

    function login(LoginRequest $request,UserRepositorie $userRepo)
    {
    	$inputData = $request->all();
    	try {
	    	$res = $userRepo->getUser($inputData);
	    	if($res){
	    		$response = [
	            'status' => 1,
	            'data' => "Success"
	        	];	
	    	}else{
	    		$response = [
	            'status' => 0,
	            'data' => "Invlaid Login Details"
	        	];	
	    	}
	    	

	        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    	}catch(\Exception $e){    		
    		$response = [
	            'status' => 0,
	            'data' => "Invlaid Login Details....",
	        ];

    		return response()->json($response, 500, [], JSON_PRETTY_PRINT);
    	}

    }
    
}
