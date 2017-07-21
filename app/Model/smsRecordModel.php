<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class smsRecordModel extends Model
{
    protected $table = 'cs_sms_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-211 用sms_sn取得sms_record資訊
    public function get_sms_by_sn($sms_sn)
    {
        /**
         * 改寫
         */
        $this->db->where('sn', $sms_sn);
        $query = $this->db->get('cs_sms_record');
        return $query->row();
    }

    # m-212 更新 簡訊紀錄表內容
    public function update_cs_sms_record($sn,$data_array)
    {
        /**
         * 改寫
         */
        $sms_status = 'fail';	#要改
        if( in_array($data_array['statuscode'],array('0','1')) || in_array($data_array,array('success')) )
        {
            $sms_status = 'success';	#要改
        }

        $sms_data = array(
            'sms_status' 		=> $sms_status,
            'reback_code'		=> $data_array['statuscode'],
            'aptg_message_sn' 	=> $data_array['msgid'],
            'update_time' 		=> time(),
        );
        $this->db->where('sn',$sn);
        $this->db->update('cs_sms_record',$sms_data);
    }

    # m-213 新增 簡訊紀錄表內容
    public function insert_cs_sms_record($sms_array)
    {
        /**
         * 改寫
         */
        $insert_sms_data = array(
            'to_mobile' 		=> $sms_array['to_mobile'],
            'sms_message' 		=> $sms_array['sms_message'],
            'create_time' 		=> time(),
            'want_send_time' 	=> ( !empty($sms_array['want_send_time']) )? $sms_array['want_send_time'] : time(),
            'send_type' 		=> $sms_array['send_type'],
            'sender_sn'			=> $sms_array['sender_sn'],
            'sms_goal'			=> $sms_array['sms_goal'],
            'remark' 			=> ( !empty($sms_array['remark']) )? $sms_array['remark'] : '' ,
            'sms_status' 		=> 'waiting', #要改
        );

        $this->db->insert('cs_sms_record',$insert_sms_data);
    }

    # m-214 拿取需要發送的簡訊
    public function get_want_sent_sms()
    {
        return $this->where('sms_status','waiting')
            ->where('want_send_time', '<=', time())
            ->get();
    }

}
