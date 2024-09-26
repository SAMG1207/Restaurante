<?php
namespace App\Helpers;

Class Responser{
    public static function response(int $code, string|array|bool $message){
        header('Content-Type: application/json');
        http_response_code($code);
        $status = match(http_response_code()){
            200, 201 => "success",
            400, 401, 404, 405 => 'error'
        };
        echo json_encode(
        ['status'=>$status,
        'message'=>$message]);
    }
}