<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityRegistListModel extends Model
{
    protected $table = 'cs_activity_regist_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
