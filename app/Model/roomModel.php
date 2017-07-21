<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class roomModel extends Model
{
    protected $table = 'cs_room';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-51 尋找某個人的所有聊天室編號
    public function get_member_chatroom_sn($member_sn)
    {
        return $this->where('start_member',$member_sn)
            ->orWhere('get_member',$member_sn)
            ->get();
    }

    # m-53 尋找某兩位使用者個room
    public function get_chatting_room_info($user_member_sn,$target_member_sn)
    {
        /**
         * 這裡多測幾次，感覺有問題
         */
        return $this->where('start_member' , $user_member_sn)
            ->where('get_member' , $target_member_sn)
            ->orWhere('start_member' , $target_member_sn)
            ->where('get_member' , $user_member_sn)
            ->get();
    }


    # m-58 取出聊天room內容
    public function get_chatting_room($where_array)
    {
        return $this->where($where_array)->get();
    }

    # m-59 取得聊天室與最後一筆聊天記錄
    public function get_chatting_room_list($member_sn, $order, $limit, $offset)
    {
        $query = <<<EOQ
select 
cs_room.sn as sn
cs_room.start_member as start_member
cs_room.get_member as get_member
cs_room.room_name as room_name
cs_room.create_time as create_time
from cs_room
rmin.sn as c_sn
rmin.sender_member_sn as c_sender_member_sn
rmin.reciver_member_sn as c_reciver_member_sn
rmin.content as c_content
rmin.send_time as c_send_time,
rmin.read_time as c_read_time
left join cs_message_content_m as rmin on cs_room.room_name = rmin.room_name
left join cs_message_content_m as rmax on rmax.room_name = rmin.room_name and rmin.send_time < rmax.send_time
where rmax.send_time is NULL and (cs_room.start_member = :memberSn or cs_room.get_member = :memberSn)
EOQ;

        $condition['memberSn'] = $member_sn;

        # 預設一個排序方式，避免以後要用
        if($order == null ){
            $query .= ' order by c_send_time desc';
        }

        if($limit != 'all') {
            $query .= ' limit :limit , :offset';
            $condition['limit'] = $limit;
            $condition['offset'] = $offset;
        }

        return DB::select($query, $condition);
    }

    # m-34 新增聊天ROOM群組
    function insert_room_data($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_room',$insert_array);
        $room_sn = $this->db->insert_id();

        return $room_sn;
    }

    public function delete_chatting($member_sn_1,$member_sn_2)
    {
        $query = <<<EOQ
            DELETE
            FROM
                cs_room
            WHERE
                (
                    start_member = :member_sn_1
                    AND get_member = :member_sn_2
                )
            OR (
                start_member = :member_sn_2
                AND get_member = :member_sn_1
            )
EOQ;

        $condition['member_sn_1'] = $member_sn_1;
        $condition['member_sn_2'] = $member_sn_2;

        return DB::select($query, $condition);
    }
}
