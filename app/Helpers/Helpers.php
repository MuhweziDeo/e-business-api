<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;


class Helpers
{
    static function formatErrors($errorObject)
    {
        $errors = [];
        foreach($errorObject as $key => $value) {
            foreach($value->messages() as $message) {
                    array_push($errors, $message[0]);
            }
        }
        return $errors;

    }

    static function validate(Array $data, Array $rules, Array $messages=[])
    {

        $validate = Validator::make($data, $rules, $messages);

        if($validate->fails()) {
            return ['errors' => $validate->errors()];
        }
    }

    static function encode_string($string)
    {

        return base64_encode($string);
    }

    static function decode_string($encoded_string)
    {

        return base64_decode($encoded_string);
    }
}
