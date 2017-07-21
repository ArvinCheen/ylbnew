<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class activitySModel extends Model
{
    protected $table = 'cs_activity_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-01 拿取X筆驗證通過且尚未開始(開始時間大於目前時間)的活動場次資料，以創立時間排序
    # get_pass_activity
    public function getPassActivity($limit)
    {
        return DB::select('select * from cs_activity_s')->toSql();

        return $this->where('start_time', '>', time())
            ->where('activity_verify_sn', '=', '1')
            ->orderBy('create_time', 'asc')
            ->limit($limit)
            ->get();

//        $this->db->from('cs_activity_s');
//        $this->db->where('start_time >',$nowTime);
//        $this->db->where('activity_verify_sn','1');
//        $this->db->order_by("create_time");
//        $this->db->limit($x);
//
//        return $this->db->get()->result();
    }
}
