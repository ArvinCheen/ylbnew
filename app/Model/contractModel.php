<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class contractModel extends Model
{
    protected $table = 'cs_contract';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # 拉出 所有契約內容資料
    # get_contract_content_data
    function getContract()
    {
        return $this->get();
//        $this->db->select('cs_contract.*,');
//
//        $this->db->from('cs_contract');
//
//        return $this->db->get()->result();
    }

    # 取 單一契約內容資料 by content_sn
    # get_contract_content_data_by_content_sn
//    function get_contract_content_data_by_content_sn($content_sn)
//    {
//        沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->select('cs_contract.*,');
//
//        $this->db->from('cs_contract');
//
//        $condition = array(
//            'cs_contract.sn' => $content_sn,
//        );
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
//    }
}
