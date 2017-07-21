<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityVerifyModel extends Model
{
    protected $table = 'cs_activity_verify';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
