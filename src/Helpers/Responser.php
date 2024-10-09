<?php
namespace App\Helpers;

Class Responser{
    public static function response(int $code, string|array|bool $message){
        header('Content-Type: application/json');
        http_response_code($code);
        $status = match (true) {
            $code >= 200 && $code < 300 => "success",
            $code >= 300  => "error",
            
            default => "unknown"
        };
        echo json_encode(
        ['status'=>$status,
        'message'=>$message]);
    }


   
}