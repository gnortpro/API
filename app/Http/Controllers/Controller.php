<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const ERROR_USER_EXISTED = 1;
    const ERROR_INVALID_LOGIN = 2;
    const ERROR_REFRESH_TOKEN_EXPIRED = 5;
    const ERROR_POLICY = 5;
    const ERROR_REF_ID_INVALID = 10;
    const ERROR_ACCESS_TOKEN = 401;
    const ERROR_BAD_REQUEST = 400;
    const ERROR_RESTRICT = 403;
    const ERROR_INTERNAL = 500;
    
    static $errorMessage = [
        self::ERROR_USER_EXISTED => "Định danh User đã tồn tại",
        self::ERROR_INVALID_LOGIN => "Thông tin đăng nhập không chính xác",
        self::ERROR_REFRESH_TOKEN_EXPIRED => "refresh_token không tồn tại hoặc đã hết hạn",
        self::ERROR_REF_ID_INVALID => "ref_id không tồn tại hoặc đã hết hạn",
        self::ERROR_ACCESS_TOKEN => "access_token hết hạn",
        self::ERROR_RESTRICT => "Không có quyền truy vấn",
        self::ERROR_BAD_REQUEST => "Truy vẫn không hợp lệ",
        self::ERROR_INTERNAL => "Lỗi hệ thống",
        self::ERROR_POLICY => "Không hủy trong 24h còn lại",
    ];

    public static function getErrorMessage($errorCode)
    {
        return self::$errorMessage[$errorCode];
    }

    function successResponse($data, $msg = "Không có lỗi khi truy vấn API")
    {
        return response()->json(['err' => 0, 'data' => $data, 'msg' => $msg]);
    }

    function errorResponse($err, $data, $msg)
    {
        return response()->json(['err' => $err, 'data' => $data, 'msg' => $msg]);
    }
}
