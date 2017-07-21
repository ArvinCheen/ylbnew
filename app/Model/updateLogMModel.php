<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class updateLogMModel extends Model
{
    protected $table = 'cs_update_log_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
