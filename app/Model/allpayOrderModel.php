<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class allpayOrderModel extends Model
{
    protected $table = 'cs_allpay_order';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-02 新增一筆新的訂單
    # insert_new_allpay_order
    function insertNewAllpayOrder($insertData)
    {
        return $this->insertGetId($insertData);

//        $this->db->insert('cs_allpay_order', $data);
//        $result = $this->db->insert_id();
//
//        if($result)
//        {
//            return $result;
//        }
//
//        return FALSE;
    }

    # m-03 更新一筆訂單
    # update_order_single_data
    function updateOrderSingleData($sn, $updateData)
    {

        return $this->where('sn', $sn)->update($updateData);
//
//        $this->db->where('order_sn', $order_sn);
//        $result = $this->db->update('cs_allpay_order', $data);
//
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-04 取會員的最近上一筆訂單資料~帶入$member_sn：會員sn
    # get_last_order_by_member_sn
    function getLastOrder($memberSn)
    {
        return $this->where('member_sn', $memberSn)
            ->where('customer_email', '!=', '')
            ->where('customer_name', '!=', '')
            ->where('customer_addr', '!=', '')
            ->orderBy('order_create_time', 'DESC')
            ->limit(1)
            ->get();
        /**
         * 注意！！
         * Controller接收端那裡的判斷要改為if (empty($get_order_info))
         * 不能使用「if ($get_order_info != NULL)」
         */

//        $this->db->from('cs_allpay_order');
//        $this->db->where('member_sn', $member_sn);
//        $this->db->where('customer_email !=', '');
//        $this->db->where('customer_name !=', '');
//        $this->db->where('customer_addr !=', '');
//        $this->db->order_by('order_create_time', 'DESC');
//        $this->db->limit(1);
//        return $this->db->get()->row();
    }


    # m-05 找allpay訂單
    # get_allpay_order
    public function getAllpayOrder($orderSn)
    {
        return $this->where('order_sn', $orderSn)
            ->orderBy('order_create_time', 'DESC')
            ->get();

        /**
         * 原「get_allpay_order」的KEY對應到「order_sn」的
         * 將($order_where_array,'all',FALSE) 改為($orderSn)
         * 例：
         * ----------------------------------------------------------------------------
         * $where_array = array(
         *      'order_sn' => $order_sn,
         * );
         * $allpay_order_info = $this->Allpay_model->get_allpay_order($where_array,'all',FALSE);
         * ----------------------------------------------------------------------------
         * 改為
         * ----------------------------------------------------------------------------
         * $order_sn = $order_sn
         * $allpay_order_info = $this->allpayOrderModel->getAllpayOrder($order_sn);
         * ----------------------------------------------------------------------------
         */
//        $this->db->from('cs_allpay_order');
//        $this->db->where($where_array);
//        $this->db->order_by('order_create_time', 'DESC');
//
//        if($x != 'all')
//        {
//            $this->db->limit($x,$offset);
//        }
//
//        return $this->db->get()->result();
    }

    # get_allpay_order
    public function getMemberNotPaymentAllpayOrder($member_sn, $limit = false, $offset = false)
    {

        $query = '
            select * from cs_access_list 
            where member_sn = :member_sn
        ';

        $condition = [
            'member_sn' => $member_sn,
        ];

        if (!$limit) {
            $query .= ' limit :limit , :offset';
            $condition['limit'] = $limit;
            $condition['offset'] = $offset;
        }

        return DB::select($query, $condition);

        /**
         * 原「get_allpay_order」的KEY對應到「member_sn」的
         * 將($order_where_array,'all',FALSE) 改為($member_sn)
         * 例：
         * ----------------------------------------------------------------------------
         * $where_array = array(
         *      'member_sn'     => $member_sn,
         *      'payment !='    => '',
         * );
         * $allpay_order_info = $this->Allpay_model->get_allpay_order($where_array,'all',FALSE);
         * ----------------------------------------------------------------------------
         * 改為
         * ----------------------------------------------------------------------------
         * $member_sn = $member_sn
         * $allpay_order_info = $this->allpayOrderModel->getMemberNotPaymentAllpayOrder($member_sn);
         * 如果有帶分頁的話 ↓↓↓
         * $allpay_order_info = $this->allpayOrderModel->getMemberNotPaymentAllpayOrder($member_sn, $config["per_page"], $from);
         * ----------------------------------------------------------------------------
         */

//        $this->db->from('cs_allpay_order');
//        $this->db->where($where_array);
//        $this->db->order_by('order_create_time', 'DESC');
//
//        if($limit != 'all')
//        {
//            $this->db->limit($limit, $offset);
//        }
//
//        return $this->db->get()->result();

    }

    # delete_allpay_order
    public function deleteAllpayOrder($memberSn)
    {
        return $this->where('member_sn', $memberSn)->delete();
//        $this->db->where('member_sn', $member_sn);
//        $this->db->delete('cs_allpay_order');
    }

    # 判斷會員對某產品有無付款紀錄
//    public function get_product_pay_status($productSn, $memberSn)
//    {
//        沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->select('pay_status');
//        $this->db->select('remark');
//        $this->db->from('cs_allpay_order');
//        $this->db->where('product_sn', $product_sn);
//        $this->db->where('member_sn', $member_sn);
//        $this->db->order_by('sn','DESC');
//        $this->db->limit(1);
//
//        return $this->db->get()->result();
//    }

//    # 判斷會員有無某類別產品成功付款紀錄
//    public function get_product_pay_status_any($product_class,$member_sn)
//    {
//        沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到沒用到
//        $this->db->from('cs_allpay_order');
//        $this->db->join('cs_production_item','cs_allpay_order.product_sn = cs_production_item.sn','left');
//        $this->db->where('cs_production_item.classic', $product_class);
//        $this->db->where('cs_allpay_order.member_sn', $member_sn);
//        $this->db->where('cs_allpay_order.pay_status', 'success');
//        $this->db->order_by('cs_allpay_order.sn','DESC');
//        $this->db->limit(1);
//
//        return $this->db->get()->result();
//    }
}
