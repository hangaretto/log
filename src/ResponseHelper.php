<?php

namespace Magnetar\Log;

use Response;

class ResponseHelper
{

    public static function dictionary($hash) {

        $message_array = [
            "successful" => "Successful",
            "not.found" => "Not found",
            "update" => "Successful create/update",

            "not.found.log_template" => "Log template is not found",
            "log_template.disabled" => "Template is disabled",

            "not.found.level" => "Level is not found",
            "log.validation.user_id" => "Log validation error. user_db needed user_id value"
        ];

        if (array_key_exists($hash, $message_array))
            return $message_array[$hash];
        else
            return $hash;

    }

    public static function response_success($message, $data = null) {

        $out = [
            "status" => "success",
            "code" => $message,
            "message" => self::dictionary($message)
        ];

        if($data != null)
            $out["data"] = $data;

        return Response::json($out, 200);

    }

    public static function response_error($data, $code) {

        $message = [400 => "validation error", 401 => "unauthorized", 403 => "access denied", 404 => "not found"];

        if(is_string($data)) {

            $error_message_code = $data;
            $data = self::dictionary($data);

        }

        $out = [
            "status" => "error",
            "message" => $message[$code],
            "error" => [
                "error_code" =>  $code,
                "error_message" => $data
            ]
        ];

        if(isset($error_message_code))
            $out['error']['error_message_code'] = $error_message_code;

        return Response::json($out, $code);

    }

}