<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class eContractContentMModel extends Model
{
    protected $table = 'cs_e_contract_content_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 更新 契約 content
    function update_contract_content_by_e_contract_sn($data)
    {
        /**
         * e_contract_sn 和 sn 是一樣的？
         *
         * 原程式碼改寫
         * $update_data = array();
         * $update_data['e_contract_sn'] = $e_contract_data[0]->sn;
         * $update_data['content'] = $preview_contract_html;
         * $update_data['create_time'] = time();
         * $update_data_result = $this->admins_contract_model->update_contract_content_by_e_contract_sn($update_data);
         * 改寫為
         * $updateData = ['content' => $preview_contract_html, 'create_time' => time()]
         * $update_data_result = $eContractContentMModel->where($e_contract_data[0]->sn)->update($updateData);
         *
         */
//        $condition = array(
//            'cs_e_contract_content_m.e_contract_sn' => $data['e_contract_sn'],
//        );
//
//        $this->db->where($condition);
//        return $this->db->update('cs_e_contract_content_m', $data);
    }

    # m-17 新增電子合約內容
    # create_e_contract_content
    public function create_e_contract_content($insert_array)
    {

        /**
         * Controller 改寫為
         * $insertData = array(
         *      'xxx' => $xxx,
         *      ……
         *      'xxx' => $xxx,
         * );
         * $update_data_result = $eContractModel->insertGetId($insertData);
         *
         */
//        $this->db->insert('cs_e_contract_content_m',$insert_array);
//        $e_contract_content_sn = $this->db->insert_id();
//
//        return $e_contract_content_sn;
    }

}
