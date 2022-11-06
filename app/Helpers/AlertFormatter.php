<?php

namespace App\Helpers;

/**
 * Format response.
 */
class AlertFormatter
{
    /**
     * Alert Response
     *
     * @var array
     */
    protected static $response = [
        'status' => "success",
        'message' => null,
        'type' => "SUKSES"
    ];

    /**
     * Give success response.
     */
    public static function success($message = null)
    {
        self::$response['message'] = $message;

        return self::$response;
    }

    /**
     * Give info response.
     */
    public static function info($message = null)
    {
        self::$response['status'] = 'info';
        self::$response['type'] = "INFO";
        self::$response['message'] = $message;

        return self::$response;
    }
    /**
     * Give warning response.
     */
    public static function warning($message = null)
    {
        self::$response['status'] = 'warning';
        self::$response['type'] = "PERINGATAN";
        self::$response['message'] = $message;

        return self::$response;
    }
    /**
     * Give danger response.
     */
    public static function danger($message = null)
    {

        self::$response['status'] = 'danger';
        self::$response['type'] = "EROR";
        self::$response['message'] = $message;

        return self::$response;
    }
}