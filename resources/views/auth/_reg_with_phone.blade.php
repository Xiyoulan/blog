<div role="tabpanel" class="tab-pane {{ active_class(if_route('register')&&if_query('way','phone')) }}" id="phone-register">
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

