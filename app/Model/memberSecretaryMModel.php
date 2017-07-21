<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberSecretaryMModel extends Model
{
    protected $table = 'cs_member_secretary_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
