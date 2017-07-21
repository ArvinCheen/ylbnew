<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class companyInfoSModel extends Model
{
    protected $table = 'cs_company_info_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-02 拿出公司資料表內的資訊
    # get_company_info
    function getCompanyInfo($companyName)
    {
        return $this->where('company_name_e', $companyName)->get();

        /**
         * 改寫
         * $company_where_array = array(
         *      'company_name_e' => $hall
         * );
         * $company_info = $this->Public_info_model->get_company_info($company_where_array);
         * 改寫為
         * $company_info = $this->companyInfoSModel->getCompanyInfo($companyName);
         */
//        $this->db->from('cs_company_info_s');
//        $this->db->where($where_array);
//
//        return $this->db->get()->result();
    }
}
