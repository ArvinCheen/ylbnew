<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interviewRoomInfoSModel extends Model
{
    protected $table = 'cs_interview_room_info_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-71 拿取訪談室價錢 by 條件
    public function get_interview_room_value($whereArray)
    {
        return $this->select('value')
            ->where('room_type', $whereArray['room_type'])
            ->where('ir_work_status', $whereArray['working'])
            ->get();
    }

}
