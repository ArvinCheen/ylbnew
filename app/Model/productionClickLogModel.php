<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class productionClickLogModel extends Model
{
    protected $table = 'cs_production_click_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
