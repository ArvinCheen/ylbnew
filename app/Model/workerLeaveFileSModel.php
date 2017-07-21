<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class workerLeaveFileSModel extends Model
{
    protected $table = 'cs_worker_leave_file_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
