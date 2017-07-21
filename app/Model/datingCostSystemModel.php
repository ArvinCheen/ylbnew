<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class datingCostSystemModel extends Model
{
    protected $table = 'cs_dating_cost_system';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    //沒用到
}
