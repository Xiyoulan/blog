<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Xiyoulan') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="{{ active_class(if_route('articles.index')) }}"><a href="{{ route('articles.index') }}">话题</a>
                    </li>
                    <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}"><a
                                href="{{ route('categories.show', 1) }}">分享</a></li>
                    <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 2))) }}"><a
                                href="{{ route('categories.show', 2) }}">资源</a></li>
                    <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 3))) }}"><a
                                href="{{ route('categories.show', 3) }}">问答</a></li>
                    <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 4))) }}"><a
                                href="{{ route('categories.show', 4) }}">闲情</a></li>
                </ul>
                <form class="navbar-form navbar-left" action="{{route('search')}}">
                    <div class="form-group" >
                        <input type="text" name="query" class="form-control" value="{{Request::input('query')}}" placeholder="Search" required>
                    </div>
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </form>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">登 录</a></li>
                        <li><a href="{{ route('register') }}">注 册</a></li>
                    @else
                        <li><a href="{{ route('articles.create') }}">创作&nbsp;<span
                                        class="glyphicon glyphicon-plus"></span></a></li>
                        {{-- 消息通知标记 --}}
                        <li>
                            <a href="{{ route('user.notification') }}" class="notifications-badge"
                               style="margin-top: -2px;">
                            <span class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }} "
                                  title="消息提醒">
                                {{ Auth::user()->notification_count }}
                            </span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px"
                                     height="30px">
                            </span>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('users.show',Auth::id()) }}">
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                        个人中心
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.show',[Auth::id(),'tab'=>'edit']) }}">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        编辑资料
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                           if(confirm('确认退出?')){
                                               document.getElementById('logout-form').submit();
                                           }
                                           ">
                                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                        退出登录
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>