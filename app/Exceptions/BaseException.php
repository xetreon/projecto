<?php

namespace App\Exceptions;
use Exception;

class BaseException extends Exception {
    public function __construct($message, $code = 400) {
        parent::__construct($message, $code);
    }

    public function render($request) {

        $error                  = [];
        $code                   = env('APP_NAME') . "_COMMON";
        $error['result']        = false;
        $error['data']          = [];
        $error['message']       = $this->getMessage();
        $error['error']         = [];
        $error['error']['type'] = substr(strrchr(get_class($this), "\\"), 1);
        if (env('APP_ENV') != 'production') {
            $error['error']['file'] = $this->getFile();
            $error['error']['line'] = $this->getLine();
        }

        if (!empty($this->getFile())) {

            $codeIndex = str_replace(base_path(), '', $this->getFile());
            if (!empty(config('controllercode')[$codeIndex])) {
                $code = config('controllercode')[$codeIndex];
                if (!empty($this->getLine())) {
                    $code = $code . '-' . $this->getLine();
                }
            }

        }

        $time = date('Y-m-d H:i:s');

        $error['error']['code'] = $code;
        $error['error']['time'] = $time;

        return response()->json($error, $this->getCode());
    }
}