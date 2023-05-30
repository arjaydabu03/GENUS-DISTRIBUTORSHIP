<?php

namespace App\Functions;

use App\Response\Message;

class GlobalFunction
{
    // SUCCESS
    public static function save($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::CREATED_STATUS
        );
    }
    public static function response_function($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::SUCESS_STATUS
        );
    }
    // ERRORS
    public static function not_found($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::DATA_NOT_FOUND
        );
    }

    public static function invalid($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::UNPROCESS_STATUS
        );
    }

    public static function denied($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::DENIED_STATUS
        );
    }
    public static function cutoff($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Message::CUT_OFF_STATUS
        );
    }
}
