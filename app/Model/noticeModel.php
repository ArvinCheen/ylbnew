<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class noticeModel extends Model
{
    protected $table = 'cs_notice';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    public function insertNotice($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_notice', $insert_array);
        return $this->db->insert_id();
    }

    # m-86 更新通知資料表
    public function update_notice($where_array,$update_array)
    {
        $this->where($where_array)->update('cs_notice',$update_array);
    }



    # -89 取得會員通知
    public function fetch_notice($member_sn,$read_status,$type,$limit,$offset)
    {
        $query = DB::table('cs_notice')->where('reciver',$member_sn);

        if($read_status != 'all') {
            $query->where('read_status',$read_status);
        }

        if($type != 'all') {
            $query->where('type',$type);
        }

        $query->order_by("create_time", "desc");

        if($limit != 'all') {
            $query->limit($limit, $offset);
        }
        return $query->get();
    }

    # -90 計算通知數量
    public function count_notice($member_sn,$read_status,$type)
    {
        $query = DB::table('cs_notice')->select('sn')->where('reciver',$member_sn);

        if($read_status != 'all') {
            $query->where('read_status',$read_status);
        }

        if($type != 'all') {
            $query->where('type',$type);
        }

        return $query->count();
    }
}
