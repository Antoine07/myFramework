<?php

use Services\App;

if (!function_exists('view')) {


    function view($path, array $data = [])
    {
        return App::get()['view']->render($path, $data);
    }

}

if (!function_exists('url')) {

    function url($url)
    {
        if ($url == '/') return WEBSITE;

        return WEBSITE . '/' . $url;
    }
}

if (!function_exists('e')) {

    function e($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if (!function_exists('dd')) {

    function dd($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        die;
    }
}

if (!function_exists('make_password')) {


    function make_password($value, $cost = 10)
    {

        $hash = password_hash($value, PASSWORD_BCRYPT, ['cost' => $cost]);

        if ($hash === false) {
            throw new \RuntimeException("Bcrypt hashing not supported.");
        }

        return $hash;
    }

}