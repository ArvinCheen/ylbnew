<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class realityVerifyOrderMModel extends Model
{
    protected $table = 'cs_reality_verify_order_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-117 新增現場預約認證資料
    function insert_reality_verify($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_reality_verify_order_m', $insert_array);
        $insert_sn = $this->db->insert_id();

        return $insert_sn;
    }

    # m-118 提取預約現場驗證資料的最後X筆(最新X筆)，加上審核狀態
    function get_reality_verify($member_sn,$num)
    {
        $this->leftJoin('cs_data_verify_m','cs_reality_verify_order_m.verify_sn', '=', 'cs_data_verify_m.sn')
            ->where('cs_reality_verify_order_m.member_sn',$member_sn)
            ->order_by('cs_reality_verify_order_m.create_time','DESC')
            ->limit($num)
            ->get();
    }

    function get_reality_verify_by_condition($member_sn,$verify_status)
    {
        return $this->select('cs_reality_verify_order_m.sn as member_onsite_verity_sn',
            'cs_data_verify_m.sn as verify_sn',
            'cs_reality_verify_order_m.*',
            'cs_data_verify_m.verify_status',
            'cs_data_verify_m.verify_worker',
            'cs_data_verify_m.verify_time',
            'cs_data_verify_m.verify_result',
            'cs_data_verify_m.verify_remark',
            'cs_data_verify_m.verify_endtime'
        )->leftJoin('cs_data_verify_m','cs_data_verify_m.sn', '=', 'cs_reality_verify_order_m.verify_sn')
        ->where('cs_data_verify_m.verify_status',$verify_status)
        ->where('cs_reality_verify_order_m.member_sn',$member_sn)
        ->get();
    }
}
