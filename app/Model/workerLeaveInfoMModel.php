<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class workerLeaveInfoMModel extends Model
{
    protected $table = 'cs_worker_leave_info_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
