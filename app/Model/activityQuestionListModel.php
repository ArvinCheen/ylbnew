<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityQuestionListModel extends Model
{
    protected $table = 'cs_activity_question_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
