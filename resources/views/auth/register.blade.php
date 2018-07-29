@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#email-register" aria-controls="email-register" role="tab" data-toggle="tab">邮 箱 注 册</a></li>
                    <li role="presentation"><a href="#phone-register" aria-controls="phone-register" role="tab" data-toggle="tab">手 机 注 册</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="email-register">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">用户名</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">邮 箱</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">密 码</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">确 认 密 码</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }}">
                                <label for="captcha" class="col-md-4 control-label">验证码</label>

                                <div class="col-md-6">
                                    <input id="captcha" class="form-control" name="captcha" >

                                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src = '/captcha/flat?' + Math.random()" title="点击图片重新获取验证码">

                                    @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        注 册
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="phone-register">
                        <form class="form-horizontal" method="POST" action="{{ route('registerWithPhone') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">手 机 号 码</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('verificationCode') ? ' has-error' : '' }}">
                                <label for="verificationCode" class="col-md-4 control-label"></label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="verificationCode" type="text" name ="verificationCode" class="form-control" placeholder="免费获取验证码" aria-label="">
                                        <div class="input-group-btn">
                                            <!-- Button and dropdown menu -->
                                            <button type="button" id="verificationCodeBtn" class="btn btn-default " aria-haspopup="true" aria-expanded="false" onclick="sendVerificationCode()">获取验证码</button>
                                        </div>
                                    </div>

                                    @if ($errors->has('verificationCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verificationCode') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        确 认
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function sendVerificationCode() {
        var phone = $('#phone').val();
        var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(16[6]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if (!phone) {
            alert("请输入手机号码！");
            return;
        }
        if (phone) {
            if (!myreg.test(phone)) {
                alert("请输入有效的手机号码！");
                $("#phone").val("");
                return;
            }
        }
        curCount = count;
        //设置button效果，开始计时
        $("#verificationCodeBtn").attr("disabled", "true");
        $("#verificationCodeBtn").val(curCount + "秒重新获取验证码");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        //向后台发送处理数据
//        $.post("{{ route('sendVerificationCode')}}",
//                {'phone': $('#phone').val()},
//                function (data) {
//                    console.log(data);
//                }
//        );
        $.ajax({
            type: "POST",
            url: "{{ route('sendVerificationCode')}}",
            data: {phone: $('#phone').val()},
            success: function (data) {
                alert(data['message']);
            },
//            statusCode: {
//                429: function () {
//                    alert('发送短信的请求太频繁了');
//                },
//                422: function (data) {
//                   alert('手机号码已存在或者格式有误!');
//                }
//            }
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status == 429) {
                    alert('发送短信的请求太频繁了');
                }
                if (XMLHttpRequest.status == 422) {
                    alert('手机号码已存在或者格式有误!');
                }
                window.clearInterval(InterValObj);//停止计时器
                $("#verificationCodeBtn").removeAttr("disabled");//启用按钮
                $("#verificationCodeBtn").html("获取验证码");
            },

        });
    }

//timer处理函数
    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#verificationCodeBtn").removeAttr("disabled");//启用按钮
            $("#verificationCodeBtn").html("重新发送验证码");
        } else {
            curCount--;
            $("#verificationCodeBtn").html(curCount + "秒后重新获取");
        }
    }
</script>
@endsection