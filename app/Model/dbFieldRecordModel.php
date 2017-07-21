<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class dbFieldRecordModel extends Model
{
    protected $table = 'cs_db_field_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    //沒用到
}
