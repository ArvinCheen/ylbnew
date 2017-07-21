<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class serviceOrderModel extends Model
{
    protected $table = 'cs_service_order';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-43 互動管理 ( 被動 )，找出非約會且 service_order 的 relation_member_sn 是自己的 service_order_sn
    public function get_service_sn_exclude_date($member_sn)
    {
        $where_array = array(
            'match_chat',
            'match_confession',
            'match_in_relationship',
            'match_in_marry',
        );
        return $this->select('cs_service_order.sn')
            ->where('order_member_sn',$member_sn)
            ->where('ask_creater_sn !=',$member_sn)
            ->whereIn('service_item',$where_array)
            ->get();
    }


    # m-44 拿取某會員的互動管理資料 (被動) ( 不管是計算或篩選都只能 where_in 上面兩個 model 的 service_order_sn )
    public function get_interaction_by_member($member_sn,$service_item,$num_in_page,$from,$reply_or_not,$serviceorder_sn)
    {
        $query = DB::table('cs_service_order')
            ->select('cs_service_order.sn AS s_sn', 'cs_service_order.*', 'cs_personal_point_s.*')
            ->leftJoin('cs_personal_point_s', 'cs_personal_point_s.member_sn', '=', 'cs_service_order.relation_member_sn');
        if($reply_or_not != 'all') {
            $query->where('cs_service_order.reply_result',$reply_or_not);
        }

        if($service_item != 'all_interaction') {
            switch($service_item) {
                case 'match_chat': 				# M+聊天
                case 'match_date': 				# M+約會
                case 'match_confession':		# M+告白
                case 'match_in_relationship': 	# M+交往
                case 'match_in_marry':			# M+結婚
                    $query->where('cs_service_order.service_item',$service_item);
                    break;
                default:
                    break;
            }
        }

        $query->whereIn('cs_service_order.sn',$serviceorder_sn);

        $query->orderBy('cs_service_order.order_date','DESC');
        if ($num_in_page > 0) {
            $query->limit($num_in_page, $from);
        }

        return $query->get();
    }


    # m-46 互動管理 ( 主動 ) 找出非約會且 service_order 的 order_member_sn 是自己的 service_order_sn
    public function get_send_service_sn_exclude_date($member_sn)
    {
        $where_array = array(
            'match_chat',
            'match_confession',
            'match_in_relationship',
            'match_in_marry',
        );
        return $this->select('cs_service_order.sn')
            ->where('ask_creater_sn',$member_sn)
            ->where('order_member_sn',$member_sn)
            ->whereIn('service_item',$where_array)
            ->get();
    }


    # m-47 拿取某會員的互動管理資料 (主動)
    public function get_send_interaction_by_member($member_sn,$service_item,$num_in_page,$from,$reply_or_not,$serviceorder_sn)
    {
        $query = DB::table('cs_service_order')
            ->select('cs_service_order.sn AS s_sn', 'cs_service_order.*', 'cs_personal_point_s.*')
            ->leftJoin('cs_personal_point_s', 'cs_personal_point_s.member_sn', '=', 'cs_service_order.relation_member_sn');

        if($reply_or_not != 'all') {
            $query->where('cs_service_order.reply_result', $reply_or_not);
        }

        if($service_item != 'all_interaction')
        {
            switch($service_item)
            {
                case 'match_chat': 				# M+聊天
                case 'match_date': 				# M+約會
                case 'match_confession':		# M+告白
                case 'match_in_relationship': 	# M+交往
                case 'match_in_marry':			# M+結婚
                    $query->where('cs_service_order.service_item',$service_item);
                    break;
                default:
                    break;
            }
        }

        $query->whereIn('cs_service_order.sn',$serviceorder_sn);
        $query->orderBy('cs_service_order.order_date','DESC');
        if ($num_in_page > 0) {
            $query->limit($num_in_page, $from);
        }

        return $query->get();
    }


    # m-48 拿取互動訂單資料by系統編號
    public function get_interaction_by_sn($service_order_sn)
    {
        return $this->where('sn',$service_order_sn)->get();
    }

    # m-49 拿取互動訂單資料by 條件
    public function get_service_order($where_array)
    {
        return $this->where($where_array)->get();
    }

    # m-60 尋找M+開通服務購買定單
    public function get_m_plus_server_order($where_array)
    {
        return $this->where($where_array)
            ->limit(1)
            ->get();
    }
    # m-65 拿取某位會員的購買服務定單資料by 會員編號與服務項目
    public function get_service_orderBy_member_sn_item($member_sn,$service_item,$service_sn)
    {
        return $this->where('order_member_sn',$member_sn)
            ->where('service_item',$service_item)
            ->where('service_sn',$service_sn)
            ->orderBy('cs_service_order.order_date','DESC')
            ->limit(1)
            ->get();
    }

    # m-66 拿取某位會員的購買服務定單資料 (目前時間要在開始時間與結束時間內)
    public function get_service_order_in_time($where_array)
    {
        return $this->where($where_array)
            ->where('start_time', '<=', time())
            ->where('end_time', '>=', time())
            ->orderBy('cs_service_order.order_date', 'DESC')
            ->limit(1)
            ->get();

    }
    # m-xx 拿取某位會員的購買服務定單資料與付款紀錄
    public function get_service_order_with_allpay($where_array)
    {
        return DB::table('cs_service_order')->select(
            'cs_service_order.sn as sn',
            'cs_service_order.order_member_sn as order_member_sn',
            'cs_service_order.relation_member_sn as relation_member_sn',
            'cs_service_order.service_item as service_item',
            'cs_service_order.ask_creater_sn as ask_creater_sn',
            'cs_service_order.reply_time as reply_time',
            'cs_service_order.reply_result as reply_result',
            'cs_service_order.result_remark as result_remark',
            'cs_service_order.service_sn as service_sn',
            'cs_service_order.order_date as order_date',
            'cs_service_order.point as point',
            'cs_service_order.start_time as start_time',
            'cs_service_order.end_time as end_time',
            'cs_service_order.contract_sn as contract_sn',
            'cs_allpay_order.sn as a_sn',
            'cs_allpay_order.order_sn as a_order_sn',
            'cs_allpay_order.order_create_time as a_order_create_time',
            'cs_allpay_order.payment as a_payment',
            'cs_allpay_order.order_totalamount as a_order_totalamount',
            'cs_allpay_order.order_status as a_order_status',
            'cs_allpay_order.pay_status as a_pay_status',
            'cs_allpay_order.remark as a_remark'
        )->leftJoin('cs_allpay_order','cs_service_order.allpay_sn = cs_allpay_order.sn')
            ->where($where_array)
            ->orderBy('cs_service_order.order_date','DESC')
            ->get();
    }


    # m-XX 拿取某位會員的購買服務定單資料，與產品名稱 (主要查詢有沒有買過體驗)
    public function get_service_order_with_product($where_array)
    {
        return $this->leftJoin('cs_production_item','cs_service_order.service_sn', '=', 'cs_production_item.sn')
            ->where($where_array)
            ->orderBy('cs_service_order.order_date','DESC')
            ->get();
    }

    # m-XX 拿取某位會員時間內的購買服務定單資料，與產品名稱 (主要查詢有沒有買過體驗)
    public function get_service_order_with_product_in_time($where_array)
    {
        return $this->leftJoin('cs_production_item','cs_service_order.service_sn', '=', 'cs_production_item.sn')
            ->where($where_array)
            ->where('start_time', '<=',time())
            ->where('end_time', '>=',time())
            ->orderBy('cs_service_order.order_date','DESC')
            ->get();
    }


    # insert 資料 進 cs_service_order
    function insert_service_order($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_service_order', $insert_data);

        return $this->db->insert_id();
    }

    # 更新service_order by sn
    function update_service_orderBy_sn($data)
    {
        /**
         * 改寫
         */
        $condition = array(
            'sn' => $data['sn'],
        );
        $this->db->where($condition);
        $this->db->update('cs_service_order', $data);
    }

//    function get_service_order($member_sn,$x='all',$offset)
//    {
    /**
     * function 重複，看怎麼合拼
     */
//        $query = DB::table('cs_service_order')
//            ->where('order_member_sn',$member_sn)
//            ->where('contract_sn', '!=','');
//
//        if($x != 'all'){
//            $query->limit($x, $offset);
//        }
//        $query->orderBy('sn','DESC');
//
//        return $query->get();
//    }
    public function change_member_service_order($member_sn,$member_type)
    {
        $now = TIME();
        if($member_type != 'pre_member')
        {
            $update_array = array(
                'reply_result' => 'success',
                'reply_time' => $now,
                'start_time' => '971976065',
                'end_time' => '1918660865',
            );
        }
        else
        {
            $update_array = array(
                'reply_result' => '',
                'reply_time' => '',
                'start_time' => '',
                'end_time' => '',
            );
        }



        return $this->where('order_member_sn',$member_sn)
            ->where('service_item','match_pass')
            ->update('cs_service_order', $update_array);
    }

    public function change_member_level($member_sn,$member_type)
    {
        $update_array = array(
            'member_type' => $member_type,
        );

        return $this->where('member_sn',$member_sn)->update('cs_member_data_s', $update_array);
    }

//    public function get_service_order($member_mobile_1,$member_mobile_2)
//    {
    /**
     * function 重複，看怎麼合拼
     */
//        $this->db->from('cs_service_order');
//        $where_array = "(order_member_sn = '".$member_mobile_1."' and relation_member_sn = '".$member_mobile_2."') or (order_member_sn = '".$member_mobile_2."' and relation_member_sn = '".$member_mobile_1."')";
//        #$where_array = "(order_member_sn = 'MEM1476333714066' and relation_member_sn = 'MEM1476342743047') or (order_member_sn = 'MEM1476342743047' and relation_member_sn = 'MEM1476333714066')";
//        $this->db->where($where_array);
//        $result = $this->db->get()->result();
//
//        if ($result)
//        {
//            return $result;
//        }
//
//        return FALSE;
//
//    }

    public function delete_interaction($sn)
    {
        /**
         * 改寫
         */
        $this->db->where('sn', $sn);
        $this->db->delete('cs_service_order');
    }


    # �M��M+�}�q�A���ʶR�w��
    public function get_server_order($where_array)
    {
        return $this->where($where_array)->get();
    }

    # ��s�ʶR�A�ȭq��
    public function update_service_order($update_array,$where_array)
    {
        return $this->whereIn('sn',$where_array)->update('cs_service_order',$update_array);
    }

    # 取得一定時間內的邀請單 match_chat ( service_order )
    public function get_service_order_alert_for_chat()
    {
        return $this->leftJoin('cs_member_data_s', 'cs_service_order.relation_member_sn', '=', 'cs_member_data_s.member_sn')
            ->where('service_item','match_chat')
            ->where('reply_result','waiting')
            ->where('member_type','formal_member')
            ->where('ask_creater_sn = order_member_sn')
            ->groupBy('relation_member_sn')
            ->get();
    }

    # 取得一定時間內的邀請單 match_date ( service_order )
    public function get_service_order_alert_for_date()
    {
        return $this->leftJoin('cs_dating_record', 'cs_service_order.service_sn', '=', 'cs_dating_record.sn')
            ->leftJoin('cs_member_data_s', 'cs_dating_record.reciver = cs_member_data_s.member_sn')
            ->where('service_item','match_date')
            ->where('reply_result','waiting')
            ->where('member_type','formal_member')
            ->where('ask_creater_sn = order_member_sn')
            ->groupBy('cs_dating_record.reciver')
            ->get();
    }

    # m-84 取得尚未抓取的互動 notice
    public function getUnCronServiceOrder()
    {
        $this->leftJoin('cs_personal_point_s','cs_service_order.relation_member_sn', '=', 'cs_personal_point_s.member_sn')
            ->where('notice_status','yes')
            ->get();
    }

    # 取聊天室資料(依 會員搜尋 訊息來源 回覆狀況 邀約日期)
    function get_match_chatroom_data_by_condition($custom_query,$reply_result,$create_time_begin,$create_time_end,$x,$offset)
    {
        $query = DB::table('cs_service_order')->select(
            'cs_service_order.sn',
            'FROM_UNIXTIME(cs_service_order.order_date,"Y-%m-%d" as member_order_date',
            'a_member.name as sender_name',
            'a_member.member_sn as sender_member_sn',
            'b_member.name as receiver_name',
            'b_member.member_sn as receiver_member_sn',
            'FROM_UNIXTIME(cs_service_order.reply_time,"%Y-%m-%d") as member_reply_time',
            'cs_service_order.reply_result',
            'cs_room.room_name'
        )
            ->leftJoin('cs_room', 'cs_service_order.ask_creater_sn = cs_room.get_member AND cs_service_order.relation_member_sn', '=', 'cs_room.start_member')
            ->leftJoin('cs_personal_point_s a_member', 'a_member.member_sn', '=', 'cs_service_order.ask_creater_sn')
            ->leftJoin('cs_personal_point_s b_member', 'b_member.member_sn', '=', 'cs_service_order.relation_member_sn')
            ->leftJoin('cs_member_data_s a_mobile', 'a_mobile.member_sn', '=', 'cs_service_order.ask_creater_sn')
            ->leftJoin('cs_member_data_s b_mobile', 'b_mobile.member_sn', '=', 'cs_service_order.relation_member_sn')

            # 服務項目：聊天
            ->where('cs_service_order.service_item', 'match_chat');
        # 取 邀約與受邀人 不相同 的資料
        $custom_query_ask_relation = "cs_service_order.ask_creater_sn != cs_service_order.relation_member_sn";
        $query->where($custom_query_ask_relation);

        # 條件判斷 會員搜尋
        if(!empty($custom_query)) {
            $query->where($custom_query);
        }

        # 回覆狀況
        if(!empty($reply_result)) {
            $query->where('cs_service_order.reply_result', $reply_result);
        }

        # 邀約時間 開始
        if(!empty($create_time_begin)) {
            $query->where('cs_service_order.order_date', '>=', $create_time_begin);
        }
        # 邀約時間 結束
        if(!empty($create_time_end)) {
            $query->where('cs_service_order.order_date', '<=', $create_time_end);
        }

        if($x != 'all') {
            $query->limit($x, $offset);
        }

        $query->orderBy('cs_service_order.sn','DESC');
        return $this->db->get()->result();
    }
}
