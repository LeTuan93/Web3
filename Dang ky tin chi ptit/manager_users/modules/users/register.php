<?php
if (!defined('_CODE')) {
    die('Access denied');
}

$session  = getSession();

$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

if($user['registration_status'] == 1){
    setFlashData('smg', 'Bạn đã đăng ký nguyện vọng rồi!!');
    setFlashData('smg_type', 'danger');
    redirect('?module=home&action=dashboard');
}


if (isPost()) {
    $preferencesJson = $_POST['preferences'];

    $preferences = json_decode($preferencesJson, true);

    if (is_array($preferences) && count($preferences) === 3) {
        //Kiểm tra từng companies xem còn slot không  nếu 1 công ty không còn slot là hủy luôn
        foreach ($preferences as $preference) {
            $companyId = $preference['company_id'];
            $company = oneRaw("SELECT * FROM companies WHERE id=$companyId");
            if ($company['registered_slots'] >= $company['total_slots']) {
                setFlashData('smg', 'Công ty ' . $company['name'] . ' đã hết xuất đăng ký!!');
                setFlashData('smg_type', 'danger');
                redirect('?module=students&action=dashboard');
            }
        }
        
        foreach ($preferences as $preference) {
            // lưu vào cơ sở dữ liệu registration với các trường là user_id, company_id, priority và status mặc định chưa duyệt, create_at
            $companyId = $preference['company_id'];
            $priorityOrder = $preference['priority_order'];
            
            $dataInsert = [
                'user_id' => $userId,
                'company_id' => $companyId,
                'priority' => $priorityOrder,
                'status' => "Chưa duyệt",
                'create_at' => date('Y-m-d H:i:s')
            ];

            insert('registration', $dataInsert);
        }
        setFlashData('smg', 'Đăng ký nguyện vọng thành công!!');
        setFlashData('smg_type', 'success');

        //Cập nhật trạng thái registration_status là true trong table users 
        $dataUpdate = [
            'registration_status' => 1,
            'update_at' => date('Y-m-d H:i:s')
        ];
        update('users', $dataUpdate, "id=$userId");

    

        redirect('?module=home&action=dashboard');
    } else {
        echo "Dữ liệu không hợp lệ!";
    }
}


