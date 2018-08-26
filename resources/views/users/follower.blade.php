@extends('layouts.app')

@section('title','收藏')

@section('content')
    <div class="widewrapper main">
        <div class="container">
            <div class="row">
                <div class="col-md-9 app-main">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            @if($action==="followers")
                                <h3>关注TA的人</h3>
                            @elseif($action==="followings")
                                <h3>TA关注的人</h3>
                            @endif
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach($users as $item)
                                    <li class="list-group-item">
                                        <a href="{{ route('users.show',$item->id) }}}">
                                            <img src="{{ $item->avatar }}" class="img-thumbnail img-responsive list-avatar">
                                        </a>
                                        <a href="{{ route('users.show',$item->id) }}}">
                                            {{$item->name}}
                                        </a>{{$item->introduction?' - '.$item->introduction:''}}
                                    </li>
                                @endforeach

                            </ul>
                            <div class="text-center">
                                {!! $users->links('pagination.default-sm')  !!} 
                            </div>
                        </div>
                    </div>
                </div>
                @include('users._aside')
            </div>
        </div>
    </div>
@endsection