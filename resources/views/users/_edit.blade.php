<div class="panel panel-default">
    <div class="panel-heading">个人信息</div>
    <div class="panel-body">
        @include('commons._error')
        <form id="user-info-form" action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="name-field">用户名</label>
                <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" disabled/>
            </div>
            <div class="form-group">
                <label for="email-field">邮 箱</label>
                <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" disabled/>
            </div>
            <div class="form-group">
                <label for="introduction-field">个人简介</label>
                <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
            </div>
            <div class="form-group">
                <label for="" class="avatar-label">用户头像</label>
                <input type="file" name="avatar">

                @if($user->avatar)
                <br>
                <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
                @endif
            </div>
            <button type="submit" class="btn btn-default">保存设置</button>
        </form>
    </div>

</div>
<div class="panel panel-default">
    <div class="panel-heading">重置密码</div>
    <div class="panel-body">
        <form class='form-horizontal' id="reset-password-form" action="{{ route('users.resetPassword', $user->id) }}" method="POST" accept-charset="UTF-8">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group{{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">旧 密 码:</label>

                <div class="col-md-6">
                    <input id="email" type="password" class="form-control" name="oldPassword" required>
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">新 密 码:</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">确 认 密 码:</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn btn-default">提交修改</button>
        </form>
    </div>

</div>

