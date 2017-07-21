<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class datingRecordModel extends Model
{
    protected $table = 'cs_dating_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # m-88 取得約會紀錄 by sn
    public function getDatingRecord($sn)
    {
        /**
         * 使用 $datingRecordModel->find($sn)
         */

//        $this->db->from('cs_dating_record');
//        $this->db->where('sn', $sn);
//
//        return $this->db->get()->result();
    }


    # m-41 依照時間範圍取得單一使用者的約會邀約紀錄判斷方式 ??????
    # 帶入$member_sn: 會員sn，查詢與此會員相關的所有約會紀錄（被邀請或邀請者）
    # 在$time_start 和 $time_end的時間範圍內
    # 帶入$check_status：狀態
    # get_dating_forward_log_by_time
    function get_dating_forward_log_by_time($memberSn, $startTime, $endTime, $status)
    {
        $query = <<<EOQ
            SELECT
                cs_dating_record.*, a.nickname AS member_name_f,
                b.nickname AS member_name_r,
                sa.sn AS sa_sn
            FROM
                cs_dating_record AS dr
            LEFT JOIN cs_personal_point_s AS pp ON pp.member_sn = dr.sender
            AND pp.member_sn = dr.reciver
            LEFT JOIN cs_service_order AS so ON so.service_sn = dr.sn
            AND so.service_item = "match_date"
            AND so.order_member_sn = :memberSn
            WHERE
                dr.dating_time > :startTime
            AND dr.dating_time < :endTime
            AND so.reply_result = :status
            AND dr.sender = :memberSn
            OR dr.reciver = :memberSn
EOQ;

        $condition = [
            'memberSn'  => $memberSn,
            'startTime' => $startTime,
            'endTime'   => $endTime,
            'status'    => $status,
        ];

        return DB::select($query, $condition);

//        $this->db->select('cs_dating_record.*, a.nickname as member_name_f, b.nickname as member_name_r, sa.sn as sa_sn');
//        $this->db->from('cs_dating_record');
//        $this->db->join('cs_personal_point_s as a', 'a.member_sn = cs_dating_record.sender', 'left');
//        $this->db->join('cs_personal_point_s as b', 'b.member_sn = cs_dating_record.reciver', 'left');
//        $this->db->join('cs_service_order as sa', 'sa.service_sn =  cs_dating_record.sn and service_item = "match_date" and order_member_sn = "'.$member_sn.'"', 'left');
//        $this->db->where('cs_dating_record.dating_time >', $time_start);
//        $this->db->where('cs_dating_record.dating_time <', $time_end);
//        $this->db->where('sa.reply_result', $check_status);
//        $where = "(`cs_dating_record`.`sender` = '$member_sn' OR `cs_dating_record`.`reciver` = '$member_sn')";
//        $this->db->where($where, NULL, FALSE);
//        #$this->db->group_by('cs_dating_record.sn');
//
//        return $this->db->get()->result();

    }

    # m-42 互動管理 ( 被動 )，發給我的，找 cs_dating_record 的 reciver 是自己的 service order sn，order_member_sn 要是自己的那張才是自己的單
    # get_service_sn_by_dating_record
    public function get_service_sn_by_dating_record($memberSn)
    {
        return $this->select('cs_service_order.sn')
            ->leftJoin('cs_service_order', 'cs_dating_record.sn', '=', 'cs_service_order.service_sn')
            ->where('cs_service_order.service_item', 'match_date')
            ->where('cs_dating_record.reciver', $memberSn)
            ->where('cs_service_order.order_member_sn', $memberSn)
            ->get();

//        $this->db->select('cs_service_order.sn');
//        $this->db->from('cs_dating_record');
//        $this->db->join('cs_service_order', 'cs_dating_record.sn = cs_service_order.service_sn','LEFT');
//        $this->db->where('cs_service_order.service_item','match_date');
//        $this->db->where('cs_dating_record.reciver',$member_sn);
//        $this->db->where('cs_service_order.order_member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }


    # m-45 互動管理 ( 主動 )，我發出的，找 cs_dating_record 的 sender 是自己的 service order sn
    # get_send_service_sn_by_dating_record
    public function get_send_service_sn_by_dating_record($memberSn)
    {
        return $this->select('cs_service_order.sn')
            ->leftJoin('cs_service_order', 'cs_dating_record.sn', '=', 'cs_service_order.service_sn')
            ->where('cs_service_order.service_item', 'match_date')
            ->where('cs_dating_record.sender', $memberSn)
            ->where('cs_service_order.order_member_sn', $memberSn)
            ->get();

//        $this->db->select('cs_service_order.sn');
//        $this->db->from('cs_dating_record');
//        $this->db->join('cs_service_order', 'cs_dating_record.sn = cs_service_order.service_sn','LEFT');
//        $this->db->where('cs_service_order.service_item','match_date');
//        $this->db->where('cs_dating_record.sender',$member_sn);
//        #$this->db->where('cs_service_order.ask_creater_sn',$member_sn);
//        $this->db->where('cs_service_order.order_member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }

    # m-63 拿取約會紀錄表
    # get_dating_record
//    public function getDatingRecord($sn)
//    {
        /**
         * 使用 $datingRecordModel->find($sn)
         */
//        $this->db->from('cs_dating_record');
//        $this->db->where($where_array);
//
//        return $this->db->get()->result();
//    }

    # m-78 拿取約會紀錄表 有or_where
    # get_dating_record_or_where
    public function getDatingRecordOnBoth($sender, $reciver)
    {
        /**
         * 改寫程式
         * $user_where_array 	= array('sender' => $member_sn,);
         * $user_or_array 		= array('reciver' => $member_sn,);
         * $user_record 		= $this->Match_plus_dating_model->get_dating_record_or_where($user_where_array,$user_or_array);
         * 改寫為
         * $user_record 		= $this->datingRecordModel->get_dating_record_or_where($user_where_array,$user_or_array);
         *
         */
        return $this->where('sender', $sender)
            ->orWhere('reciver', $reciver)
            ->get();

//        $this->db->from('cs_dating_record');
//        $this->db->where($where_array);
//        $this->db->or_where($or_where_array);
//
//        return $this->db->get()->result();
    }

}
