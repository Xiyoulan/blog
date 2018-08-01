@extends('layouts.app')
@section('title','个人主页--'.$user->name)
@section('content')
<div class="widewrapper main">
    <div class="container">
        <div class="row">
            @include('users._main')
            @include('users._aside')
        </div>
    </div>
</div>
@endsection

