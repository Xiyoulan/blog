@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">等待用户激活</h3>
                </div>

                <div class="panel-body">
                    <div>
                        <div class='alert alert-warning'>
                            亲爱的{{$user->name}},为保证网站的纯净，新注册用户需要激活后才能登录，我们已经将包含激活链接的邮件发送到你的注册邮箱，请注意查收，点击邮件中的激活用户链接即可激活用户。
                        </div>   
                        
                        <form id="resendEmail"action="{{route('resendEmail',$user->id)}}" method="post">
                            {{csrf_field()}}
                            <button class ='btn btn-primary btn-block' type='submit'>没有接受到邮件,重新发送</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


