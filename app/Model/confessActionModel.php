<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class confessActionModel extends Model
{
    protected $table = 'cs_confess_action';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # delete_confession
    public function delete_confession($sn)
    {
        return $this->where('sn', $sn)->delete();
//        $this->db->where('sn', $sn);
//        $this->db->delete('cs_confess_action');
    }

    # m-50 拿取告白文件
    # get_confess_info
    public function getConfessInfo($sn)
    {
        return $this->where('sn', $sn)->get();

        /**
         * 將程式碼改寫
         * $where_array = array(
         * 'sn' => $sender_service_order_info[0]->service_sn,
         * );
         * $confess_info = $this->Interaction_model->get_confess_info($where_array);
         * 改寫為
         * $confess_info = $this->confessActionModel->getConfessInfo($sn);
         */
//        $this->db->from('cs_confess_action');
//        $this->db->where($where_array);
//
//        return $this->db->get()->result();
    }


    # m-36 新增告白紀錄。
    # insert_confess_action
    function insertConfessAction($insertData)
    {
        return $this->insertGetId($insertData);

//        $insert_action = $this->db->insert('cs_confess_action', $insert_array);
//        $result_sn = $this->db->insert_id();
//
//        return $result_sn;
    }


    # m-37 當被告白方回覆告白時，從表更新告白互動紀錄，更新欄位為回覆時間與回覆結果
    # update_confess_action
    function updateConfessAction($sn, $updateData)
    {
        return $this->where('sn', $sn)->update($updateData);
//        $this->db->where('sn',$sn);
//        $update_action = $this->db->update('cs_confess_action', $update_array);
//
//        if($update_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

}
