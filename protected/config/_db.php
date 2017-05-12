<?php

if((!defined('PRODUCTION') || !PRODUCTION) && (!isset($_SERVER['HTTP_ADDR']) || !$_SERVER['HTTP_ADDR'] || preg_match('/?(127\.0\.|192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.).*$/', $_SERVER['HTTP_ADDR']) == 1 ))  {
    return array(
        'connectionString' => 'mysql:host=localhost;dbname=picomsu_lenina100',
        'emulatePrepare' => true,
        'username' => 'picomsu',
        'password' => 'NyAIh9kH',
        'charset' => 'utf8',
        'tablePrefix' => 'rd_',
        'enableProfiling'=>true,
        'enableParamLogging' => true,
    );
} else {
    return require('_dbproduction.php');
};
