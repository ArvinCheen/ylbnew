<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberAccountModel extends Model
{
    protected $table = 'cs_member_account';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_member_account
    # 拉出 cs_member_account 全部/最新一筆 記錄
    public function get_member_account($member_sn, $limit = false, $offset = false)
    {
        if ($limit) {
            return $this->where('member_sn', $member_sn)
                ->limit($limit)
                ->offset($offset)
                ->orderBy('sn', 'desc')
                ->get();
        } else {
            return $this->where('member_sn', $member_sn)
                ->orderBy('sn', 'desc')
                ->get();
        }
    }

    # insert 資料 進 cs_member_account
    public function insert_member_account($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_member_account', $insert_data);

        return $this->db->insert_id();
    }

    # m-93 新增個人帳戶資料
//    public function insert_member_account($insert_array)
//    {
//        /**
//         * function 同名
//         * 改寫
//         */
//        $this->db->insert('cs_member_account',$insert_array);
//        $member_account_data_sn = $this->db->insert_id();
//
//        return $member_account_data_sn;
//    }

    # cs_member_account
    # JOIN service_order
    function get_member_account_with_service_order($memberSn)
    {
        /**
         * 改寫
         * controller limit and offset remove
         */
        return $this->select('cs_member_account.*, cs_service_order.service_item, cs_service_order.result_remark')
            ->leftJoin('cs_service_order', 'cs_service_order.sn', '=', 'cs_member_account.detail_sn')
            ->where('member_sn', $memberSn)
            ->orderBy('cs_member_account.sn', 'desc')
            ->get();
    }

    public function change_member_points($member_sn,$member_points,$point_count)
    {
        /**
         * 改寫
         */
        $now = TIME();
        $insert_array = array (
            'member_sn' => $member_sn,
            'point' => $member_points,
            'point_start_time' => $now,
            'point_end_time' => '1887124865',
            'action_type' => 'buy_points',
            'create_time' => $now,
            'balance' => $point_count + $member_points,
        );

        $this->db->insert('cs_member_account', $insert_array);
        $insert_sn = $this->db->insert_id();

        return  $insert_sn;
    }

    public function sum_member_points($memberSn)
    {
        return $this->where('action_type', 'buy_points')
            ->where('member_sn', $memberSn)
            ->sum('point');
    }

    # m-91 查詢目前帳戶月老幣餘額
    public function get_ylb_balance($memberSn)
    {
        return $this->select('balance')
            ->where('member_sn', $memberSn)
            ->limit(1)
            ->orderBy('create_time', 'desc')
            ->get();
    }


    # m-92 選取某個使用者的通知紀錄X筆
    public function get_pay_log($where_array, $limit = null, $offset = null, $type_choices = null, $item_choices = null)
    {
        $query = <<<EOQ
            SELECT
                ma.point,
                ma.action_type,
                ma.create_time,
                ma.balance,
                so.service_item,
                so.reply_result,
                so.reply_time,
                so.relation_member_sn
            FROM
                cs_member_account AS ma
            LEFT JOIN cs_service_order AS so ON cs_service_order.sn = ma.detail_sn
            WHERE
                ma.member_sn = :memberSn
            AND me.detail_sn IS NOT NULL
EOQ;

        $condition['memberSn'] = $where_array['member_sn'];

        if ($type_choices != null && $type_choices != 'all') {
            $query .= ' AND ma.action_type = :typeChoices';

            $condition['typeChoices'] = $type_choices;
        }

        if ($item_choices != null && $item_choices != 'all') {
            $query .= ' AND so.service_item = :itemChoices';
            $condition['itemChoices'] = $item_choices;
        }

        if($limit != null) {
            $query .= ' LIMIT :limit, :offset';
            $condition['limit'] = $limit;
            $condition['offset'] = $offset;
        }

        $query .= ' order by create_time desc ';

        return DB::select($query, $condition);
    }

}
