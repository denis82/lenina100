<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include('Install.php');
    $result = Install::processPost($_POST);
    $fields = Install::$fields;
    include('view.php');
; ?>