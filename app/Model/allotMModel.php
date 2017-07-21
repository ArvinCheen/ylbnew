<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class allotMModel extends Model
{
    protected $table = 'cs_allot_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_allot_m
    # 會員分配 新增分配紀錄
    # insert_assign_record
    function insertAssignRecord($insertData)
    {
        return $this->insert($insertData);
//        $this->db->insert('cs_allot_m', $insert_data);
    }

    # cs_allot_m JOIN cs_worker_info_s JOIN cs_worker_info_s as assign_secre
    # 會員分配 取目前分配紀錄
    # get_assign_record
//    function get_assign_record($condition=null)
//    {
         // 沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->select('*');
//        $this->db->select('cs_allot_m.`sn` as allot_sn');
//        $this->db->select(" CONCAT(cs_worker_info_s.`name`, ' ', cs_worker_info_s.`e_name`) as allot_worker_name,");
//        $this->db->select(" from_unixtime(cs_allot_m.create_time,'%Y-%m-%d %H:%i:%s') as allot_create_time");
//        $this->db->select("  CONCAT(assign_secre.`name`, ' ', assign_secre.`e_name`) as allot_secretary_name,");
//        $this->db->select('cst_action.describe_c as allot_action');
//        $this->db->from('cs_allot_m');
//        # 分配動作(YSA)
//        $this->db->join('cs_constant_map as cst_action', "cst_action.constant_type = 'YSA' and cst_action.describe_e = cs_allot_m.action", 'left');
//
//        $this->db->join('cs_worker_info_s','cs_worker_info_s.employee_sn = cs_allot_m.allot_worker_sn');
//        $this->db->join('cs_worker_info_s as assign_secre',' assign_secre.employee_sn = cs_allot_m.secretary');
//
//        if($condition != null)
//        {
//            $this->db->where($condition);
//        }
//
//        $this->db->order_by('cs_allot_m.`create_time` desc');
//        $this->db->order_by('cs_allot_m.`sn` asc');
//
//        return $this->db->get()->result();
//    }
}
