<?php

namespace Magnetar\Log\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Magnetar\Log\Presenters\ValidatePresenter;

class Log extends Model {

    protected $table = 'magnetar_log_logs';

    protected $rules = [
        'text' => 'required|string',
        'code' => 'required|string',
        'level' => 'required|string',
        'data' => 'required|json',
    ];

    use ValidatePresenter;

}