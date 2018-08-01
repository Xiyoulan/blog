@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="{{ active_class(if_route('register')&&!if_query('way','phone')) }}"><a href="#email-register" aria-controls="email-register" role="tab" data-toggle="tab">邮 箱 注 册</a></li>
                        <li role="presentation" class="{{ active_class(if_route('register')&&if_query('way','phone')) }}"><a href="#phone-register" aria-controls="phone-register" role="tab" data-toggle="tab">手 机 注 册</a></li>
                    </ul>
                    <div class="tab-content">
                        @include('auth._reg_with_email')
                        @include('auth._reg_with_phone')

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id ="show-info" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">通知</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
            $('#show-info .modal-body').html('请输入电话号码!');
            $('#show-info').modal('show');
            return;
        }
        if (phone) {
            if (!myreg.test(phone)) {
                $('#show-info .modal-body').html('请输入有效的电话号码!');
                $('#show-info').modal('show');
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
                $('#show-info .modal-body').html(data['message']);
                $('#show-info').modal('show');
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
                    $('#show-info .modal-body').html('发送短信的请求太频繁了');
                    $('#show-info').modal('show');
                }
                if (XMLHttpRequest.status == 422) {
                    $('#show-info .modal-body').html('手机号码已存在或者格式有误!');
                    $('#show-info').modal('show');
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