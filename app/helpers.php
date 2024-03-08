<?php

function app_url(){
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'];
}