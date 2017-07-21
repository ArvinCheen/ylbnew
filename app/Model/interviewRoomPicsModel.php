<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interviewRoomPicsModel extends Model
{
    protected $table = 'cs_interview_room_pics_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
