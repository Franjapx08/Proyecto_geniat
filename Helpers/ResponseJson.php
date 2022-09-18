<?php

class ResponseJson {

    public static function response (array $data) 
    {
        return array($data);
    }

    public static function data($data, $code)
    {
        return self::response([
            'data' => $data,
            'code' => $code,
            'error' => null
        ]);
    }
    
    public static function msg($msg, $code)
    {
        return self::response([
            'data' => [
                'msg' => $msg,
                'code' => $code,
                'error' => null
            ]
        ]);
    }

    public static function error($msg, $code, $details = [])
    {
        return self::response([
            'data' => [
                'error' => [
                    'msg' => $msg,
                    'details' => $details
                ],
                'code' => $code
            ]
        ]);
    }
}