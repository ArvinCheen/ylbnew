<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class givePointModel extends Model
{
    protected $table = 'cs_give_point';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
