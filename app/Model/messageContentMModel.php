<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class messageContentMModel extends Model
{
    protected $table = 'cs_message_content_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # m-57 查詢聊天內容
    public function search_message_content($where_array,$order_by)
    {
        $query = DB::table('cs_message_content_m')->where($where_array);

        if(!empty($order_by)) {
            $query->order_by($order_by);
        } else {
            $query->order_by("send_time DESC");
        }

        return $query->get();
    }

    # m-67 拿取有留話給使用者但使用者未讀的會員編號
    public function get_no_read_sender_sn($member_sn, $limit = 1, $offset = 10)
    {
        return $this->distinct()
            ->select('sender_member_sn')
            ->where('reciver_member_sn',$member_sn)
            ->where('read_time', null)
            ->order_by('cs_message_content_m.send_time','DESC')
            ->limit($limit, $offset)
            ->get();
    }


    # m-68 拿取輸入目標會員編號傳送給使用者會員編號的最後一筆未讀的聊天資訊
    public function get_target_member_last_message($target_member_sn,$member_sn,$count_num=NULL)
    {
        return $this->where('sender_member_sn',$target_member_sn)
        ->where('reciver_member_sn',$member_sn)
        ->where('read_time',NULL)
        ->orderBy('cs_message_content_m.send_time', 'DESC')
        ->limit(1)
        ->get();
    }


    # m-52 回傳某聊天室名稱的目前所有對話筆數
    public function get_chatting_number($where_array)
    {
        return $this->where($where_array)->get();
    }

    # m-54 新增聊天內容
    public function insert_message_content($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_message_content_m',$insert_array);
        $insert_sn = $this->db->insert_id();

        return $insert_sn;
    }
    # m-55 修改聊天內容by 條件
    public function update_message_content($where_array,$update_array)
    {
        return $this->where($where_array)
            ->where('read_time', null)
            ->update('cs_message_content_m', $update_array);
    }


    # m-56 拿取聊天內容by 條件
    public function get_message_content($where_array, $limit)
    {
        return $this->where($where_array)
        ->order_by('send_time','desc')
        ->limit($limit)
        ->get();
    }

    # m-57 查詢聊天內容
    public function serch_message_content($where_array)
    {
        return $this->where($where_array)
        ->orderBy('send_time','ASC')
        ->get();
    }

}
