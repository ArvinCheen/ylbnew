<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class outdatingPlaceModel extends Model
{
    protected $table = 'cs_outdating_place';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-64 拿取時間內的約會推薦景點 by 條件陣列
    public function get_outdating_place($where_array)
    {
        $query = DB::table('cs_outdating_place');
        if($where_array !=NULL)
        {
            $query->where($where_array);
        }
        $query->order_by('cs_outdating_place.create_time','DESC');

        return $query->get();
    }
}
