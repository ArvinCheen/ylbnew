<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberLogRecordModel extends Model
{
    protected $table = 'cs_member_log_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
