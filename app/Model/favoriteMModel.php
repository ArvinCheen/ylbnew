<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class favoriteMModel extends Model
{
    protected $table = 'cs_favorite_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-128 查詢是否關注某人
    # check_follow_member
    public function checkFollowMember($memberSn, $targetMemberSn)
    {
        return $this->where('follow_member', $memberSn)
            ->where('befollow_member', $targetMemberSn)
            ->get();

//        $this->db->from('cs_favorite_m');
//        $this->db->where('follow_member', $member_sn);
//        $this->db->where('befollow_member', $target_member_sn);
//
//        $result = $this->db->get()->result();
//
//        if ($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }


    # m-79 新增關注會員(類似加入最愛)
    # insert_favorite_list
    function insert_favorite_list($insert_array)
    {
        /**
         * 改寫
         */
//        $insert_action = $this->db->insert('cs_favorite_m', $insert_array);
//
//        if($insert_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }


    # m-80 刪除關注內容。
    # delete_favorite_list
    function delete_favorite_list($sn)
    {
        /**
         * 改寫
         */
        $this->db->where('sn',$sn);
        $delete_action = $this->db->delete('cs_favorite_m');

        if($delete_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-81 選取關注內容。查詢使用者關注的全部會員
    # select_favorite_list
    public function serachAllFavoriteMember($memberSn)
    {
        return $this->where('member_sn', $memberSn)->get();
        /**
         * 改寫以下程式
         * $follow_member_sn = $this->Follow_model->select_favorite_list($user_member_sn,NULL);
         * 改寫為
         * $follow_member_sn = $favoriteMModel->serachAllFavoriteMember($user_member_sn);
         * 第二個參數的「NULL」沒用到，所以移除
         */

//        $this->db->from('cs_favorite_m');
//        $this->db->where('follow_member',$follow_member);
//        $this->db->where_not_in('bewatch_member', $blist_number_array);
//        $this->db->order_by('follow_time','DESC');
//
//        return $this->db->get()->result();
    }

    # m-220 我的關注列表分頁
    # my_favorite_list_page
    public function getMyFavoriteList($followMemberSn, $limit, $offset)
    {
        return $this->where('follow_member', $followMemberSn)
            ->limit($limit)
            ->offset($offset)
            ->orderBy('follow_time', 'desc')
            ->get();

        /**
         * 改寫以下程式
         * $follow_member_page = $this->Follow_model->my_favorite_list_page($user_member_sn,NULL,$config["per_page"],$from);
         * 改寫為
         * $follow_member_page = $$favoriteMModel->getMyFavoriteList($user_member_sn, $config["per_page"], $from);
         * 第二個參數的「NULL」沒用到，所以移除
         */
//        $this->db->from('cs_favorite_m');
//        $this->db->where('follow_member',$follow_member);
//        $this->db->where_not_in('bewatch_member', $blist_number_array);
//        $this->db->limit($num,$offset);
//        $this->db->order_by('follow_time','DESC');
//
//        return $this->db->get()->result();
    }

    # m-82 查詢使用者會員編號是否有關注某另一位使用者
    # check_favorite_relation
    function checkFavoriteRelation($followMemberSn, $befollowMemberSn)
    {
        return $this->where('follow_member', $followMemberSn)
            ->where('befollow_member', $befollowMemberSn)
            ->get();

//        $this->db->from('cs_favorite_m');
//        $this->db->where('follow_member',$follow_member);
//        $this->db->where('befollow_member',$befollow_member);

//        return $this->db->get()->result();
    }
}
