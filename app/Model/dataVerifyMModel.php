<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class dataVerifyMModel extends Model
{
    protected $table = 'cs_data_verify_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 拉出 指定審核結果 的 member_sn 待整理
//    function xxx_get_member_sn_by_condition($verify_item='all',$verify_result='all')
//    {
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到　　　　沒用到用　到沒用到沒用　到沒用　到沒用到沒　用到沒用　到沒用到沒　用到沒用到沒用到
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用　到沒用　到沒用到沒用　到沒用　到沒用到沒用到沒用
// 沒用到沒用到　　　　沒用到沒　用到沒用到沒　用到沒用到　沒　用到沒用到沒用到　沒　用到沒用到沒用到沒用
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用到沒　用到沒用到沒用到沒用　到沒用到沒用到沒用到沒
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用到　沒　到沒用到沒用到沒　用　沒用到沒用到沒用到沒
// 沒用到沒用到　沒用到沒用到沒　　用到沒用　　到沒用到　沒到沒　用到沒用到沒　用到用　到沒用到沒用到沒用
// 沒用到沒用到　沒用到沒用到沒用　　　　　　沒用到沒　用到用到沒　用到沒用　到用到沒用　到沒用到沒用到沒
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->select('member_sn');
//        $this->db->from('cs_data_verify_m');
//
//        if(!empty($verify_result) && ($verify_result != 'all'))
//        {
//            $this->db->where('verify_result',$verify_result);
//        }
//        if(!empty($verify_item) && ($verify_item != 'all'))
//        {
//            $this->db->where('verify_item',$verify_item);
//        }
//
//        # 暫時先排除 待審核介面 完成 service_order 的部分 再移除 20170224
//        $this->db->where_not_in('verify_item','service_order');
//
//        $this->db->group_by("member_sn");
//
//        return $this->db->get()->result();
//    }


    # m-95 拿取審核資料 by 審核編號
    public function get_verify_info($verify_sn)
    {
        // Controller 改以「$dataVerifyMModel->find($sn)」直接取代
        return $this->find($verify_sn);

//        $this->db->from('cs_data_verify_m');
//        $this->db->where('cs_data_verify_m.sn',$verify_sn);
//
//        return $this->db->get()->result();
    }

    # m-119 從資料表取得使用者指定驗證資料以及審核狀態。
    # get_verify_data_info
    function getVerifyData($memberSn, $verify)
    {
        return $this->leftJoin('cs_member_attestation_m', 'cs_data_verify_m.sn', '=', 'cs_member_attestation_m.verify_sn')
            ->where('cs_member_attestation_m.member_sn', $memberSn)
            ->where('cs_member_attestation_m.verify_item', $verify)
            ->limit(1)
            ->orderBy('cs_member_attestation_m.update_time', 'desc')
            ->get();
//
//        $this->db->from('cs_data_verify_m');
//        $this->db->join('cs_member_attestation_m','cs_data_verify_m.sn = cs_member_attestation_m.verify_sn');
//        $this->db->where('cs_member_attestation_m.member_sn',$member_sn);
//        $this->db->where('cs_member_attestation_m.verify_item',$verify);
//        $this->db->order_by('cs_member_attestation_m.update_time','DESC');
//        $this->db->limit(1);
//
//        return $this->db->get()->result();
    }

    # m-182 找出最新大頭貼 (不管通過或不通過)
    # get_mug_shot_verify
    function getLatestHeadshot($memberSn)
    {
        return $this->leftJoin('cs_member_pic_m', 'cs_data_verify_m.sn', '=', 'cs_member_pic_m.verify_sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.top_pic', 'yes')
            ->limit(1)
            ->orderBy('create_time', 'desc')
            ->get();

//        $this->db->from('cs_data_verify_m');
//        $this->db->join('cs_member_pic_m', 'cs_data_verify_m.sn = cs_member_pic_m.verify_sn');
//        $this->db->where('cs_member_pic_m.member_sn', $member_sn);
//        $this->db->where('cs_member_pic_m.top_pic','yes');
//        $this->db->limit(1);
//        $this->db->order_by('create_time','DESC');
//
//
//        return $this->db->get()->result();
    }

    # m-195 用驗證項目id，拿取驗證項目與data_verify_m
    # get_verify_data_info_by_id
    public function get_verify_data_info_by_id($memberSn, $itemName)
    {

// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到　　　　沒用到用　到沒用到沒用　到沒用　到沒用到沒　用到沒用　到沒用到沒　用到沒用到沒用到
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用　到沒用　到沒用到沒用　到沒用　到沒用到沒用到沒用
// 沒用到沒用到　　　　沒用到沒　用到沒用到沒　用到沒用到　沒　用到沒用到沒用到　沒　用到沒用到沒用到沒用
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用到沒　用到沒用到沒用到沒用　到沒用到沒用到沒用到沒
// 沒用到沒用到　沒用到沒用到沒　用到沒用到沒　用到沒用到　沒　到沒用到沒用到沒　用　沒用到沒用到沒用到沒
// 沒用到沒用到　沒用到沒用到沒　　用到沒用　　到沒用到　沒到沒　用到沒用到沒　用到用　到沒用到沒用到沒用
// 沒用到沒用到　沒用到沒用到沒用　　　　　　沒用到沒　用到用到沒　用到沒用　到用到沒用　到沒用到沒用到沒
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
// 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到

//        $this->db->from('cs_data_verify_m');
//        $this->db->join('cs_member_attestation_m','cs_data_verify_m.sn=cs_member_attestation_m.verify_sn');
//        $this->db->where('cs_member_attestation_m.member_sn',$member_sn);
//        $this->db->where('cs_member_attestation_m.verify_item ',$item_name);
//        $this->db->order_by('cs_member_attestation_m.update_time','DESC');
//        $this->db->limit(1);
//
//        return $this->db->get()->result();
    }
}
