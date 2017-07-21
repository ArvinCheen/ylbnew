<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class systemPublicNoteModel extends Model
{
    protected $table = 'cs_system_public_note';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
