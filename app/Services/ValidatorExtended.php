<?php

namespace App\Services;

use Illuminate\Validation\Validator;

class ValidatorExtended extends Validator
{

    public function __construct($translator, $data, $rules, $messages = array(),
                                $customAttributes = array())
    {
        parent::__construct($translator, $data, $rules, $messages,
            $customAttributes);
    }

    protected function validateOtp($attribute, $value)
    {   
        return session('otp')==$value;
    }

    
}