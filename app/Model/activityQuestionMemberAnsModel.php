<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityQuestionMemberAnsModel extends Model
{
    protected $table = 'cs_activity_question_member_ans';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
