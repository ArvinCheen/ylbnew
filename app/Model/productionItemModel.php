<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class productionItemModel extends Model
{
    protected $table = 'cs_production_item';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
