<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberAttestationMModel extends Model
{
    protected $table = 'cs_member_attestation_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-120 從資料表取得使用者某項驗證項目以及審核狀態。
    function get_verify_data_info_s($memberSn, $verifyItem)
    {
        return $this->leftJoin('cs_data_verify_m', 'cs_data_verify_m.sn', '=', 'cs_member_attestation_m.verify_sn')
            ->where('cs_member_attestation_m.member_sn', $memberSn)
            ->where('cs_member_attestation_m.verify_item', $verifyItem)
            ->limit(1)
            ->orderBy('cs_member_attestation_m.update_time', 'desc')
            ->get();
    }

}
