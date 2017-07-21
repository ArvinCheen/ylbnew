<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberNoteModel extends Model
{
    protected $table = 'cs_member_note';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
