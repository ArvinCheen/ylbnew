<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interviewRoomWorkerMModel extends Model
{
    protected $table = 'cs_interview_room_worker_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;
}
