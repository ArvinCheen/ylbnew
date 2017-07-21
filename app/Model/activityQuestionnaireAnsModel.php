<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityQuestionnaireAnsModel extends Model
{
    protected $table = 'cs_activity_questionnaire_ans';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
