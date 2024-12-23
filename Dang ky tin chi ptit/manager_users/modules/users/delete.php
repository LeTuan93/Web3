<?php

if (!defined('_CODE')) {
    die('Access denied');
}


// Kiểm tra id trong database -> tồn tại -> tiếng hành xóa
// Xóa dữ liệu bảng loginToken -> xóa dữ liệu bảng users

$filterAll = filter();
if(!empty($filterAll['id'])){
    $userId = $filterAll['id'];
    $userDetail = getRows("SELECT * FROM users WHERE id =$userId");
    if($userDetail > 0){
        // Thực hiện xoá
        $deleteToken = delete('logintoken',"user_id = $userId");
        if($deleteToken) {
            // Xoá user
            $deleteUser = delete('users',"id=$userId");
            if($deleteUser) {
                setFlashData('smg','Xoá người dùng thành công.');
                setFlashData('smg_type','success');
            }else {
                setFlashData('smg','Lỗi hệ thống.');
                setFlashData('smg_type','danger');
            }
        }
    }else {
        setFlashData('smg','Người dùng không tồn tại trong hệ thống.');
        setFlashData('smg_type','danger');
    }

}else {
    setFlashData('smg','Liên kết không tồn tại.');
    setFlashData('smg_type','danger');
}

redirect('?module=home&action=dashboard');