<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interviewRoomOrderModel extends Model
{
    protected $table = 'cs_interview_room_order';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-69 刪除訪談室預約資料
    public function delete_interview_room_order($datingSn)
    {
        /**
         * controller丟進來的參數改寫
         */
        return $this->where('dating_sn', $datingSn)->delete();

//        $this->db->where($where_array);
//        $delete_action = $this->db->delete('cs_interview_room_order');
//        if($delete_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-74 新增包廂預約資料
    public function insert_interview_room_order($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_interview_room_order',$insert_array);
        $interview_room_info_sn = $this->db->insert_id();

        return $interview_room_info_sn;
    }

    # m-77 拿取interview_room_order資料
    public function get_interview_room_order($datingSn)
    {
        /**
         * controller丟進來的參數改寫
         */
        return $this->where('dating_sn', $datingSn)->get();
    }
}
