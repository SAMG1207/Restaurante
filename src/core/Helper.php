<?php
namespace App\Helpers;

Class Helper{
    public static function response($code, $status, $message){
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(['status'=>$status,
        'message'=>$message]);
    }
}