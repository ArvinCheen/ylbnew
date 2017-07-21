<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class bannerPicModel extends Model
{
    protected $table = 'cs_banner_pic';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-193 利用group_name拿取同一群組的banner圖片資料
    # get_banner_by_group
    public function getBannerByGroup($groupName)
    {
        return $this->where('group_name', $groupName)
            ->where('end_time >', time())
            ->orderBy('order', 'DESC')
            ->get();

//        $this->db->from('cs_banner_pic');
//        $this->db->where('group_name',$group_name);
//        $this->db->where('end_time >',time());
//        $this->db->order_by('order','DESC');
//        return $this->db->get()->result();
    }

    # get_banner_by_sn
    function getBanner($sn)
    {
        return $this->where('sn', $sn)->get();

//        $this->db->from('cs_banner_pic');
//        $this->db->where('sn',$sn);
//        return $this->db->get()->result();
    }

    # 拉出 條件內的 banner create_time 排序
    # get_banner_by_condition
    function getAllBanner()
    {
        return $this->orderBy('group_name', 'asc')
            ->orderBy('create_time', 'desc')
            ->get();

        /**
         * 原 $this->admins_banner_pic_model->get_banner_by_condition(NULL);
         * 改寫為
         * $this->admins_banner_pic_model->getAllBanner();
         * 拿掉參數裡的NULL
         * 因為是多餘的
         */
//        $this->db->select('*');
//        $this->db->from('cs_banner_pic');
//
//        if($in_condition != NULL)
//        {
//            $this->db->where_in('group_name',$in_condition);
//        }
//
//        $this->db->order_by('group_name','ASC');
//        $this->db->order_by('create_time','DESC');
//        return $this->db->get()->result();
    }

    # 新增 banner 項目 回傳新增編號
    # insert_banner
    function insertBannerAndReturnId($insertData)
    {
        return $this->insertGetId($insertData);
//        $this->db->insert('cs_banner_pic', $insert_data);
//
//        return $this->db->insert_id();
    }

    # 更新 banner 項目 by sn
    # update_banner_by_sn
    function updateBanner($updateData, $sn)
    {
        return $this->where('sn', $sn)->update($updateData);
//        $this->db->where('sn', $sn);
//        $this->db->update('cs_banner_pic', $update_data);
    }

    # 刪除 banner 項目 by sn
    # delete_banner_by_sn
    function deleteBanner($sn)
    {
        return $this->where('sn', $sn)->delete();
//        $this->db->where('sn', $sn);
//        $this->db->delete('cs_banner_pic');
    }

}
