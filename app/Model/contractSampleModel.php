<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class contractSampleModel extends Model
{
    protected $table = 'cs_contract_sample';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 拉出 所有契約樣版資料
    # get_contract_sample_data
    function get_contract_sample_data()
    {
        // Controller 改以「$contractSampleModel->get()」直接取代
        return $this->get();

//        $this->db->select('cs_contract_sample.*,');
//
//        $this->db->from('cs_contract_sample');
//
//        return $this->db->get()->result();
    }

    # 取 單一契約樣版名稱 by sample_sn
    # get_contract_sample_data_by_sample_sn
    function get_contract_sample_data_by_sample_sn($sn)
    {
        // Controller 改以「$contractTitleModel->find($sn)」直接取代
        return $this->find($sn);

//        $this->db->select('cs_contract_sample.*,');
//
//        $this->db->from('cs_contract_sample');
//
//        $condition = array(
//            'cs_contract_sample.sn' => $sample_sn,
//        );
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
    }
}
