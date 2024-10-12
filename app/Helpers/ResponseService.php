<?php

namespace App\Helpers;

class ResponseService {

    public static function TerbilangId($amount)
    {

		return $amount;
    }

    public static function success($data = [], $message = "Success"){
        $out = [
            "status" => true,
            "message" => $message,
            "code"    => 200,
            "data" => $data ?? [],
        ];
        return response()->json($out, $out['code']);
    }

    public static function notSuccess($data = [], $message = "Failed"){
        $out = [
            "status" => false,
            "message" => $message,
            "code"    => 200,
            "data" => $data ?? [],
        ];
        return response()->json($out, $out['code']);
    }

    public static function badRequest($data = [], $message = "Failed"){
        $out = [
            "status" => false,
            "message" => $message,
            "code"    => 400,
            "data" => $data ?? [],
        ];
        return response()->json($out, $out['code']);
    }

    public static function catchError($err, $message="error, please try again later or contact administrator."){
        $out = [
            "status" => true,
            "message" => env('APP_ENV') === 'PRODUCTION' ? $message:$err->getMessage(),
            "code"    => 500,
            "data" => [],
        ];
        return response()->json($out, $out['code']);

    }

    public static function unauthorized(){
        $out = [
            "status" => false,
            "message" => 'Unauthorized',
            "code"    => 401,
            "data" => [],
        ];
        return response()->json($out, $out['code']);
    }

    // public static function notFound = (res, errMsg = 'Not Found') => {
    //     res.status(404).json({
    //         error: {
    //             error: 'Not Found',
    //             status: 404,
    //             message: errMsg
    //         },
    //     })
    // }

    // public static function unauthorized = (res) => {
    //     res.status(401).json({
    //         error: {
    //             error: 'Unauthorized',
    //             status: 401,
    //             message: 'Unauthorized'
    //         },
    //     })
    // }

    // public static function forbidden = (res) => {
    //     res.status(403).json({
    //         error: {
    //             error: 'Forbidden',
    //             status: 403,
    //             message: 'Forbidden'
    //         },
    //     })
    // }


}
