<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pointPromotionModel extends Model
{
    protected $table = 'cs_point_promotion';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
