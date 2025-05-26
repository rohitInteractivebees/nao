<?php
use Illuminate\Support\Facades\Route;

if (!function_exists('isCommonRoute')) {
    function isCommonRoute(): bool
    {
        $routeArr = ['home', 'login'];
        return in_array(Route::currentRouteName(), $routeArr);
    }
}
