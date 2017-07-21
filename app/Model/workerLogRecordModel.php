<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class workerLogRecordModel extends Model
{
    protected $table = 'cs_worker_log_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
