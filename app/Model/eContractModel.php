<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class eContractModel extends Model
{
    protected $table = 'cs_e_contract';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 取 get_e_contract_data_by_member_sn
    # get_e_contract_data_by_member_sn
    # get_contract_by_member
    function getEContract($memberSn)
    {
        return $this->where('member_sn', $memberSn)->get();

//        $this->db->select('cs_e_contract.*,');
//        $condition = array(
//            'cs_e_contract.member_sn' => $member_sn,
//        );
//        $this->db->from('cs_e_contract');
//        $this->db->where($condition);
//        return $this->db->get()->result();
    }

    # 更新 契約 content
    # update_contract_content_by_e_contract_sn
    function updateContract($data)
    {
        /**
         * 改寫以下程式
         *
         * $update_data['e_contract_sn'] = $e_contract_data[0]->sn;
         * $update_data['content'] = $preview_contract_html;
         * $update_data['create_time'] = time();
         * $update_data_result = $this->admins_contract_model->update_contract_content_by_e_contract_sn($update_data);
         * 改寫為
         *
         * $updateData = ['content' => $preview_contract_html, 'create_time' => time()]
         * $update_data_result = $eContractModel->where('sn', $e_contract_data[0]->sn)->update($updateData);
         *
         */
//        $condition = array(
//            'cs_e_contract_content_m.e_contract_sn' => $data['e_contract_sn'],
//        );
//
//        $this->db->where($condition);
//        return $this->db->update('cs_e_contract_content_m', $data);
    }

    # 更新 verify_sn by e_contract_sn
    # update_verify_sn_by_e_contract_sn
    function update_verify_sn_by_e_contract_sn($sn, $data)
    {
        /**
         * 改寫以下程式
         *
         * $update_data2['e_contract_sn'] = $e_contract_data[0]->sn;
         * $update_data2['verify_sn'] = $insert_verify_sn;
         * $update_data2_result = $this->admins_contract_model->update_verify_sn_by_e_contract_sn($update_data2);
         * 改寫為
         *
         * $updateData = ['verify_sn' => $insert_verify_sn]
         * $update_data_result = $eContractModel->where('sn', $e_contract_data[0]->sn)->update($updateData);
         *
         */
//        $update_data = array(
//            'verify_sn' => $data['verify_sn'],
//        );
//
//        $condition = array(
//            'cs_e_contract.sn' => $data['e_contract_sn'],
//        );
//
//        $this->db->where($condition);
//        return $this->db->update('cs_e_contract', $update_data);
    }

    # 取得目前契約
    # get_current_contract_by_member_sn
    function getCurrentContract($memberSn)
    {
        return $this->select('cs_e_contract_content_m.content')
            ->leftJoin('cs_e_contract_content_m', 'cs_e_contract.sn', '=', 'cs_e_contract_content_m.e_contract_sn')
            ->where('cs_e_contract.member_sn', $memberSn)
            ->get();
//
//        $this->db->select('cs_e_contract_content_m.content,');
//
//        $this->db->from('cs_e_contract');
//
//        $this->db->join('cs_e_contract_content_m','cs_e_contract.sn = cs_e_contract_content_m.e_contract_sn');
//
//        $this->db->where('cs_e_contract.member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }

    # change_contract_sign_by_member
    public function changeEContract($member_sn)
    {
        $updateData = [
            'sign_time' => null,
            'sign_ip'  => null,
            'sign_ua'  => null,
        ];

        return $this->where('member_sn', $member_sn)->update($updateData);

//        $update_array = array(
//            'sign_time' 	=> NULL,
//            'sign_ip' 		=> NULL,
//            'sign_ua' 		=> NULL,
//        );
//
//        $this->db->where('member_sn',$member_sn);
//        $result = $this->db->update('cs_e_contract', $update_array);
//
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-15 更新電子合約資料表
    # update_e_contract
    public function update_e_contract($where_array,$update_array)
    {
        /**
         * 改寫以下程式
         *
         * $update_where_array = array('sn' => $e_contract_sn);
         * $update_array = array(
         *      'sign_time' => $sign_time,
         *      'sign_ip' 	=> $IP,
         *      'sign_ua' 	=> $UA,
         * );
         * $update = $this->E_contract_model->update_e_contract($update_where_array,$update_array);
         * 改寫為
         * $updateData = [
         *      'sign_time' => $sign_time,
         *      'sign_ip' => $IP,
         *      'sign_ua' => $UA
         * ]
         * $update_data_result = $eContractModel->where('sn', $e_contract_sn)->update($updateData);
         *
         */

//        $this->db->where($where_array);
//        $update_action = $this->db->update('cs_e_contract', $update_array);
//
//        if($update_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }


    # m-16 新增電子合約
    # create_e_contract
    public function create_e_contract($insert_array)
    {
        /**
         * Controller 改寫為
         * $insertData = array(
         *      'member_sn' => $member_sn,
         *      ……
         *      'creater' 	=> 'system_create'
         * );
         * $update_data_result = $eContractModel->insertGetId($insertData);
         *
         */

//        $this->db->insert('cs_e_contract',$insert_array);
//        $e_contract_sn = $this->db->insert_id();
//
//        return $e_contract_sn;
    }


    # m-18 拿取會員電子合約 by 合約編號
    public function get_cs_e_contract_by_sn($sn)
    {
        /**
         * 改寫
         * $eContractModel->find($sn);
         */
        $this->db->from('cs_e_contract');
        $this->db->where('sn',$sn);

        return $this->db->get()->result();
    }

    # m-19 拿取會員電子合約 by 會員編號
    public function get_cs_e_contract_by_member_sn($memberSn)
    {
        return $this
            ->leftJoin('cs_e_contract_content_m', 'cs_e_contract.sn', '=', 'cs_e_contract_content_m.e_contract_sn')
            ->where('cs_e_contract.member_sn', $memberSn)
            ->get();

//        $this->db->from('cs_e_contract');
//        $this->db->join('cs_e_contract_content_m', 'cs_e_contract.sn = cs_e_contract_content_m.e_contract_sn','left');
//        $this->db->where('cs_e_contract.member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }


    # m-20 取會員電子合約以及其審核狀態
    # get_contract_and_verify_status
    public function get_contract_and_verify_status($sn)
    {

        $query = <<<EOQ
            SELECT
                ec.sn AS e_contract_sn,
                ec.member_sn,
                ec.sign_time,
                ec.sign_ip,
                ec.sign_ua,
                ec.file_url,
                ec.verify_sn,
                ec.contract_classify,
                em.sn AS contract_content_sn,
                em.content,
                dm.sn AS verify_sn,
                dm.verify_status,
                dm.verify_worker,
                dm.verify_time,
                dm.verify_result,
                dm.verify_remark,
                dm.verify_item,
                dm.verify_item_sn,
                dm.member_sn,
                dm.verify_endtime
            FROM
                cs_e_contract AS ec
            LEFT JOIN cs_e_contract_content_m AS em ON ec.sn = em.e_contract_sn
            LEFT JOIN cs_data_verify_m AS dm ON ec.verify_sn = dm.sn
            WHERE
                ec.sn = :sn
EOQ;

        $condition = ['sn' => $sn];

        return DB::select($query, $condition);
        /**
         * 改寫
         *
         * $contract_info = $eContractModel->get_contract_and_verify_status($sn);
         */

//        $this->db->select('cs_e_contract.sn as e_contract_sn');
//        $this->db->select('cs_e_contract.member_sn');
//        $this->db->select('cs_e_contract.sign_time');
//        $this->db->select('cs_e_contract.sign_ip');
//        $this->db->select('cs_e_contract.sign_ua');
//        $this->db->select('cs_e_contract.file_url');
//        $this->db->select('cs_e_contract.verify_sn');
//        $this->db->select('cs_e_contract.contract_classify');
//        $this->db->select('cs_e_contract_content_m.sn as contract_content_sn');
//        $this->db->select('cs_e_contract_content_m.content');
//        $this->db->select('cs_data_verify_m.sn as verify_sn');
//        $this->db->select('cs_data_verify_m.verify_status');
//        $this->db->select('cs_data_verify_m.verify_worker');
//        $this->db->select('cs_data_verify_m.verify_time');
//        $this->db->select('cs_data_verify_m.verify_result');
//        $this->db->select('cs_data_verify_m.verify_remark');
//        $this->db->select('cs_data_verify_m.verify_item');
//        $this->db->select('cs_data_verify_m.verify_item_sn');
//        $this->db->select('cs_data_verify_m.member_sn');
//        $this->db->select('cs_data_verify_m.verify_endtime');
//
//        $this->db->from('cs_e_contract');
//        $this->db->join('cs_e_contract_content_m', 'cs_e_contract.sn = cs_e_contract_content_m.e_contract_sn','left');
//        $this->db->join('cs_data_verify_m', 'cs_e_contract.verify_sn = cs_data_verify_m.sn','left');
//        $this->db->where($where_array);
//
//        return $this->db->get()->result();
    }

    # get_contract_verify_by_condition
    function get_contract_verify_by_condition($memberSn, $verifyStatus, $limit = null)
    {

        $query = <<<EOQ
             SELECT
                ec.sn AS member_contract_sn,
                dm.sn AS verify_sn,
                ec.*, dm.verify_status,
                dm.verify_worker,
                dm.verify_time,
                dm.verify_result,
                dm.verify_remark,
                dm.verify_endtime,
                em.content,
                em.create_time AS e_create_time
            FROM
                cs_e_contract AS ec
            LEFT JOIN cs_data_verify_m AS dm ON dm.sn = ec.verify_sn
            LEFT JOIN cs_e_contract_content_m AS em ON ec.sn = em.e_contract_sn
            WHERE
                dm.verify_status = :verifyStatus
            AND ec.member_sn = :memberSn
EOQ;

        $condition = ['verifyStatus' => $verifyStatus, 'member_sn' => $memberSn];

        if ($limit) {
            $query .= ' and limit :limit order by ec.sn desc';
            $condition += ['limit' => $limit];
        }

        return DB::select($query, $condition);

//
//        $this->db->select('cs_e_contract.sn as member_contract_sn,');
//        $this->db->select('cs_data_verify_m.sn as verify_sn,');
//        $this->db->select('cs_e_contract.*,');
//        $this->db->select('cs_data_verify_m.verify_status,');
//        $this->db->select('cs_data_verify_m.verify_worker,');
//        $this->db->select('cs_data_verify_m.verify_time,');
//        $this->db->select('cs_data_verify_m.verify_result,');
//        $this->db->select('cs_data_verify_m.verify_remark,');
//        $this->db->select('cs_data_verify_m.verify_endtime,');
//        $this->db->select('cs_e_contract_content_m.content,');
//        $this->db->select('cs_e_contract_content_m.create_time as e_create_time,');
//
//        $this->db->from('cs_e_contract');
//
//        $this->db->join('cs_data_verify_m','cs_data_verify_m.sn = cs_e_contract.verify_sn');
//        $this->db->join('cs_e_contract_content_m','cs_e_contract.sn = cs_e_contract_content_m.e_contract_sn');
//
//        $this->db->where('cs_data_verify_m.verify_status',$verify_status);
//        $this->db->where('cs_e_contract.member_sn',$member_sn);
//
//        if(!empty($limit_num) and is_numeric($limit_num))
//        {
//            $this->db->order_by('cs_e_contract.sn','DESC');
//            $this->db->limit($limit_num);
//        }
//
//        return $this->db->get()->result();
    }
}
