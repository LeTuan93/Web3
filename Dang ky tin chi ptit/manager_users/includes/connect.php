<?php

if (!defined('_CODE')) {
    die('Access denied');
}

require_once '../manager_users/config.php';

try {
    if(class_exists('PDO')){
        // Chuỗi DSN (Data Source Name) chứa thông tin về cơ sở dữ liệu cần kết nối.
        $dsn = 'mysql:dbname='._DB.';host='._HOST;
        $options = [
            PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Thiết lập mã hóa ký tự giữa ứng dụng và cơ sở dữ liệu là UTF-8.
            PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION // Tạo thông báo ra ngoại lệ khi gặp lỗi
        ];
        $conn = new PDO($dsn,_USER,_PASS, $options);
    }
} catch(Exception $exception) {
    echo '<div style="color:red; padding: 5px 15px; border: 1px solid red;">';
    echo $exception -> getMessage().'<br>';
    echo '</div>';
    die();
}