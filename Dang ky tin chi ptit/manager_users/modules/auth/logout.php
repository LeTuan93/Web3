<?php

if (!defined('_CODE')) {
    die('Access denied');
}

if (isLogin()) {
    $token = getSession('logintoken');
    delete('logintoken', "token='$token'");
    removeSession(' logintoken');
    echo "<script>
    localStorage.removeItem('currentTab'); // Hoặc localStorage.clear();
    window.location.href = '?module=auth&action=login'; // Điều hướng sau khi xóa
    </script>";
    exit; // Dừng thực thi tiếp

}
