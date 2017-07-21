<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class loginInfoEverydayModel extends Model
{
    protected $table = 'cs_login_info_everyday';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
