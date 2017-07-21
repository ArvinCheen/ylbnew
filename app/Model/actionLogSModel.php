<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class actionLogSModel extends Model
{
    protected $table = 'cs_action_Log_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
