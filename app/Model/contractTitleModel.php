<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class contractTitleModel extends Model
{
    protected $table = 'cs_contract_title';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 拉出 所有契約類型資料
    # get_contract_title_data
    function getAllContractTitle()
    {
        // Controller 改以「$contractTitleModel->get()」直接取代
        return $this->get();

//        $this->db->select('cs_contract_title.*,');
//
//        $this->db->from('cs_contract_title');
//
//        return $this->db->get()->result();
    }

    # 取 單一契約類型資料 by title_sn
    # get_contract_title_data_by_title_sn
    function getContractTitle($sn)
    {
        // Controller 改以「$contractTitleModel->find($sn)」直接取代
        return $this->find($sn);

//        $this->db->select('cs_contract_title.*,');
//
//        $this->db->from('cs_contract_title');
//
//        $condition = array(
//            'cs_contract_title.sn' => $title_sn,
//        );
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
    }
}
