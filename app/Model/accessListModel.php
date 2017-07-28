<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class accessListModel extends Model
{
    protected $table = 'cs_access_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    protected $fillable = [
        'name', 'url', 'father_sn', 'order', 'show', 'create_time',
        ];

    # 權限管理 取全部權限項目
    # get_access_item
    function getAllAccessItem()
    {
        return $this->orderBy('order')->get();
    }

    # 新增權限項目 回傳新增編號
    # insert_access_item
    function insertAccessItemAndReturnSn($insertData)
    {
        /**
         * 改寫
         */
        return $this->insertGetId($insertData);
    }
    # 更新權限項目 by sn
    # update_access_item_by_sn
    function updateAccessItem($updateData, $sn)
    {
        /**
         * 改寫
         */
        return $this->where('sn', $sn)->update($updateData);
    }
    # 刪除權限項目 by sn
    # delete_access_item_by_sn
    function deleteAccessItem($sn)
    {
        /**
         * 改寫
         */
        return $this->where('sn', $sn)->delete();
    }
}
