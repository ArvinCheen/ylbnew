<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class hopePointSModel extends Model
{
    protected $table = 'cs_hope_point_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # m-28 新增會員至期許指標資料表
    public function insert_hope_point_s($insert_array)
    {
        /**
         * 改寫
         */
//        $result = $this->db->insert('cs_hope_point_s',$insert_array);
//
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-149 取得期許資料
    # get_hope_point
    public function getHopePoint($memberSn)
    {
        return $this->where('member_sn', $memberSn)->get();

//        $this->db->from('cs_hope_point_s');
//        $this->db->where('member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }


    # m-150 更新期許資料
    # update_hope_point
    function updateHopePoint($memberSn, $updateData)
    {
        return $this->where('member_sn', $memberSn)->update($updateData);
//
//        $this->db->where('member_sn',$member_sn);
//        $result = $this->db->update('cs_hope_point_s',$update_array);
//
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

}
