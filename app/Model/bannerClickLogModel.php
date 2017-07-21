<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class bannerClickLogModel extends Model
{
    protected $table = 'cs_banner_click_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # 新增 banner click log 回傳新增編號
    # insert_banner_click_log
    function insertBannerClickLogAndReturnId($insertData)
    {
        return $this->insertGetId($insertData);
//        $this->db->insert('cs_banner_click_log', $insert_data);
//
//        return $this->db->insert_id();
    }


//    function get_banner_click_log_by_sn($sn)
//    {
//        沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->from('cs_banner_click_log');
//        $this->db->where('sn',$sn);
//        return $this->db->get()->result();
//    }
}
