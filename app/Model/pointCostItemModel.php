<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pointCostItemModel extends Model
{
    protected $table = 'cs_point_cost_item';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
