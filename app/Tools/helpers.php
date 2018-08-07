<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function datetime_for_humans(\Carbon\Carbon $canbon)
{
//    if($time instanceof \Carbon\Carbon)
    $time = $canbon->timestamp;
    $now = time();
    //大于一个周就返回如2018-05-01 23:54这种格式 
    $difference = $now - $time;
    if ($difference > 60 * 60 * 24 ) {
        return $canbon->format('Y-m-d H:i ');
    } else {
        return $canbon->diffForHumans();
    }
}
