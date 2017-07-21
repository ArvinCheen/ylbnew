<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class classificationListModel extends Model
{
    protected $table = 'cs_classification_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_classification_list
    # 會員列表 會員分類 拉出秘書擁有的所有分類
    # get_member_assign_classification
    function getMemberAssignClassification($workerSn)
    {
        return $this->where('worker_sn', $workerSn)
            ->orderBy('sn')
            ->orderBy('create_time')
            ->get();

        /**
         * 將以下程式碼改寫
         * $classification_condition = array(
         *      'cs_classification_list.worker_sn' => $worker_sn,
         * );
         * $this->admins_member_list_model->get_member_assign_classification($classification_condition);
         * 改寫為
         * $this->classificationListModel->getMemberAssignClassification($workerSn);
         */
//        $this->db->select('*');
//        $this->db->from('cs_classification_list');
//
//        if($condition != null)
//        {
//            $this->db->where($condition);
//        }
//
//        $this->db->order_by('sn asc');
//        $this->db->order_by('create_time asc');
//
//        return $this->db->get()->result();
    }

    # 新增分類項目 回傳新增編號
    # insert_classification
    function insertClassification($insertData)
    {
        return $this->insertGetId($insertData);
//        $this->db->insert('cs_classification_list', $insert_data);
//        return $this->db->insert_id();
    }

    # 更新分類項目 by sn
    # update_classification_by_sn
    function updateClassification($updateData,$sn)
    {
        return $this->where('sn', $sn)->update($updateData);

//        $this->db->where('sn',$sn);
//        $this->db->update('cs_classification_list', $update_data);
    }

    # 刪除分類項目 by sn
    # delete_classification_by_sn
    function deleteClassification($sn)
    {
        return $this->where('sn', $sn)->delete();

//        $this->db->where('sn', $sn);
//        $this->db->delete('cs_classification_list');
    }
}
