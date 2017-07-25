<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>後台 | 登入</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset('global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::asset('global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::asset('global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ URL::asset('pages/css/login.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/admins">
        <img src="{{ URL::asset('img/admins_login_logo.png') }}"/> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="login" method="post">
        {{ csrf_field() }}
        <h3 class="form-title font-green">登入</h3>
        @if(session('registerFlashSuccess'))
        <div class="alert alert-success display-block">
            <button class="close" data-close="alert"></button> {{ session('registerFlashSuccess') }}
        </div>
        @endif
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> 請輸入帳號密碼 </span>
        </div>
        @if(session('loginFlashError'))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span> {{ session('loginFlashError') }} </span>
        </div>
        @endif
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">帳號</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="帳號" name="login_account" value="{{ old('login_account') }}" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">密碼</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="密碼" name="login_password"/> </div>
        <div class="form-actions">
            <input type="submit" class="btn green uppercase" name="login_submitsss" value="登入">
        </div>
        <div class="create-account">
            <p>
                <a href="javascript:;" id="register-btn" class="uppercase">建立帳號</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="register" method="post">
        {{ csrf_field() }}
        <h3 class="font-green">註冊</h3>
        @if(session('registerFlashError'))
        <div class="alert alert-danger display-block">
            <button class="close" data-close="alert"></button>{{ session('registerFlashError') }}
        </div>
        @endif
        <p class="hint">請輸入以下個人資訊： </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">所屬會館</label>
            <select id="select_location" name="location" class="form-control bs-select" title="所屬會館">
                <option class="verify-select-option" value="" selected>所屬會館</option>
                @foreach ($location as $loc_key => $loc_value)
                <option value="{{ $loc_value->describe_e }}">{{ $loc_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">職務</label>
            <select id="select_job" name="job" class="form-control bs-select" title="職務">
                <option class="verify-select-option" value="" selected>職務</option>
                @foreach ($job as $job_key => $job_value)
                <option value="{{ $job_value->describe_e }}">{{ $job_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">姓名</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="姓名" title="姓名" value="{{ old('name') }}"  name="name" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">英文名</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="英文名" title="英文名" value="{{ old('e_name') }}" name="e_name" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">暱稱</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="暱稱" title="暱稱" value="{{ old('nickname') }}" name="nickname" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">在職狀況</label>
            <select id="select_work_status" name="work_status" class="form-control bs-select" title="在職狀況">
                <option class="verify-select-option" value="" selected>在職狀況</option>
                @foreach ($work_status as $work_status_key => $work_status_value)
                <option value="{{ $work_status_value->describe_e }}">{{ $work_status_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">性別</label>
            <select id="select_gender" name="gender" class="form-control bs-select" title="性別">
                <option class="verify-select-option" value="" selected>性別</option>
                @foreach ($gender as $gender_key => $gender_value)
                <option value="{{ $gender_value->describe_e }}">{{ $gender_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">員工上班型態</label>
            <select id="select_working_type" name="working_type" class="form-control bs-select" title="員工上班型態">
                <option class="verify-select-option" value="" selected>員工上班型態</option>
                @foreach ($working_type as $working_type_key => $working_type_value)
                <option value="{{ $working_type_value->describe_e }}">{{ $working_type_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">私人手機號碼</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="私人手機號碼" title="私人手機號碼" value="{{ old('private_mobile') }}" name="private_mobile" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">公司手機號碼</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="公司手機號碼" title="公司手機號碼" value="{{ old('public_mobile') }}" name="public_mobile" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">出生年月日</label>

            <div data-date-format="yy-mm-dd" class="input-group date date-picker">
                <input class="form-control placeholder-no-fix" type="text" placeholder="出生年月日" class="form-control form-control-inline date-picker" readonly name="birthday"  title="出生年月日" value="{{ old('birthday') }}" />
                <span class="input-group-btn">
							<button class="btn default" type="button">
								<i class="fa fa-calendar"></i>
							</button>
						</span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">身分證字號</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="身分證字號" title="身分證字號" value="{{ old('roc_id') }}" name="roc_id" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">居住地址</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="居住地址" title="居住地址" value="{{ old('address') }}" name="address" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">最高學歷</label>
            <select id="select_edu" name="edu" class="form-control bs-select" title="最高學歷">
                <option class="verify-select-option" value="" selected>最高學歷</option>
                @foreach ($edu as $edu_key => $edu_value)
                <option value="{{ $edu_value->describe_e }}">{{ $edu_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">最高學歷學校</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="最高學歷學校" title="最高學歷學校" value="{{ old('school') }}" name="school" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">科系</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="科系" title="科系" value="{{ old('department') }}" name="department" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">血型</label>
            <select id="select_blood_type" name="blood_type" class="form-control bs-select" title="血型">
                <option class="verify-select-option" value="" selected>血型</option>
                @foreach ($blood_type as $blood_type_key => $blood_type_value)
                <option value="{{ $blood_type_value->describe_e }}">{{ $blood_type_value->describe_c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">緊急聯絡人</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="緊急聯絡人" title="緊急聯絡人" value="{{ old('emergency_name') }}" name="emergency_name" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">緊急聯絡人手機</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="緊急聯絡人手機" title="緊急聯絡人手機" value="{{ old('emergency_contact_mobile') }}" name="emergency_contact_mobile" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">緊急聯絡人關係</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="緊急聯絡人關係" title="緊急聯絡人關係" value="{{ old('emergency_contact_relation') }}" name="emergency_contact_relation" />
        </div>


        <p class="hint"> 請輸入以下帳號資訊： </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">帳號</label>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="帳號" name="account" title="帳號" value="{{ old('account') }}" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">密碼</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="密碼" name="password" title="密碼"/> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">再輸入一次密碼</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="再輸入一次密碼" name="rpassword"  title="再輸入一次密碼" /> </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="mt-checkbox mt-checkbox-outline">
                <!-- <input type="checkbox" name="remember" value="1" /> -->
                <input type="checkbox" name="tnc" /> 我同意
                <a href="javascript:;">月老平台服務及使用規範 </a>
                <span></span>
            </label>
            <div id="register_tnc_error"> </div>
        </div>
        <div class="form-actions">
            <button type="button" id="register-back-btn" class="btn green btn-outline">返回</button>
            <input type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right" name="create_account_submit" value="送出申請">
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>

<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::asset('global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-validation/js/localization/messages_zh_TW.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" defer="defer"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-TW.min.js') }}" type="text/javascript" defer="defer"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::asset('global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('pages/scripts/components-date-time-pickers.js') }}" type="text/javascript" defer="defer"></script>
<script src="{{ URL::asset('pages/scripts/login.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

@if(session('loginFlashSuccess') or session('registerFlashSuccess') or session('loginFlashError'))
<script>
    jQuery(document).ready(function() {
        $('.login-form').show();
        $('.register-form').hide();
    });
</script>
@endif

@if(session('registerFlashError'))
<script>
    jQuery(document).ready(function() {
        $('.login-form').hide();
        $('.register-form').show();
    });
</script>
@endif
</body>

</html>