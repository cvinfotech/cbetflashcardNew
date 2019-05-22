<?php

if(!function_exists('getCategory')){
    function getCategory($cat_id){
        $categories = \App\Category::pluck('name', 'id')->toArray();
        /*$categories = array(
            '1' => 'App',
            '2' => 'Website',
            '3' => 'Payments'
        );*/

        return isset($categories[$cat_id]) ? $categories[$cat_id] : 'Uncategorized';
    }
}
if(!function_exists('getCategories')){
    function getCategories(){
        $categories = \App\Category::pluck('name', 'id')->toArray();
        /*$categories = array(
            '1' => 'App',
            '2' => 'Website',
            '3' => 'Payments'
        );*/

        return $categories;
    }
}

if(!function_exists('getPlans')){
    function getPlans(){
        $plans = \App\Plan::pluck('plan', 'id')->toArray();
        return $plans;
    }
}

if(!function_exists('customCardCount')){
    function customCardCount(){
        $count = \App\Card::where('user_id', Auth::id())->count();
        return $count;
    }
}

if(!function_exists('favoriteCount')){
    function favoriteCount(){
        $count = \App\Favorite::where('user_id', Auth::id())->count();
        return $count;
    }
}
if(!function_exists('randomPassword')) {
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}