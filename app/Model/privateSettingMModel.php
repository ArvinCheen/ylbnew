<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class privateSettingMModel extends Model
{
    protected $table = 'cs_private_setting_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
