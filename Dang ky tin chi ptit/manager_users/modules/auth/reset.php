<?php

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Đặt lại mật khẩu'
];

layouts('header-login', $data);

$token = filter()['token'];
if (!empty($token)) {
    //Truy vấn database kiểm tra token
    $tokenQuery = oneRaw("SELECT id,fullname,email FROM users WHERE forgotToken = '$token'");
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        if (isPost()) {
            $filterAll = filter();
            $errors = []; //Mảng chứa các lỗi

            // Validate password: bat buoc phai nhap, >=8 ky tu
            if (empty($filterAll['password'])) {
                $errors['password'][' required'] = 'Mat khau båt buoc phai nhåp. ';
            } else {
                if (strlen($filterAll['password']) < 8) {
                    $errors['password']['min'] = 'Mat khau phai lon hon hoac bang 8. ';
                }
            }
            // Validate pasword_confirm: bat buoc phai nhap, giong password
            if (empty($filterAll['password_confirm'])) {
                $errors['password_confirm']['required'] = 'Ban phai nhåp lai måt khau.';
            } else {
                if (($filterAll['password']) != $filterAll['password_confirm']) {
                    $errors['password_confirm']['match'] = 'Mat khau ban nhap lai khong dung. ';
                }
            }

            if (empty($errors)) {
                //Xử lý việc update mật khẩu
                $paswordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $paswordHash,
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H: i: s')
                ];
                $updateStatus = update('users', $dataUpdate, "id = '$userId'");
                if ($updateStatus) {
                    setFlashData('msg', 'Thay đổi mật khẩu thành công !! ');
                    setFlashData('msg_type', 'success');
                    // redirect ("?module=auth&action=login");
                } else {
                    setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau !! ');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu !! ');
                setFlashData('msg_type', 'danger');
                // setFlashData('errors', $errors) ;
                redirect('?module=auth&action=reset&token=' . $token);
            }
        }
        $msg = getFlashData('msg');
        $msg_type = getFlashData('msg_type');
        $errors = getFlashData('errors');
    } else {
        getSmg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
    }
} else {
    getSmg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
?>

<!-- Form đặt lại mật khẩu -->
<div class="container-fluid">
    <div class="row position-relative" style="height: 70px;">
        <!-- Image aligned to the left -->
        <div class="col-md-3 ps-0">
            <img src="<?php echo _WEB_HOST_TEMPLATES; ?>/image/PTIT.png" class="img-fluid" alt="Cover Image" style="max-width: 80%; height: 85%;">
        </div>
        <!-- Diagonal pink section on the right -->
        <div class="col-md-9 position-absolute" style="top: 0; right: 0; height: 60%;width: 83%; ;background: linear-gradient(135deg, white 5%, #e57373 0%);">
        </div>
    </div>

    <!-- row này phải cách row trên margin 1 chút -->
    <div class="row mt-4 " style="min-height: 400px;">
        <div class="row mt-4 ">
            <!-- Notification Section -->
            <div class="col-md-12 ps-0 pe-0">
                <div class="row shadow">
                    <div class="text-white py-2 " style="background-color: #ad171c !important; border-color: #901317 !important;border: 1px solid #000;">
                        <h5 class="mb-0 ms-3">ĐẶT LẠI MẬT KHẨU</h5>
                    </div>
                    <?php
                    if (!empty($msg)) {
                        getSmg($msg, $msg_type);
                    }
                    ?>
                    <div class="row ms-1">
                        <!-- Main Announcement (Left Column) -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- Nhập mật khẩu mới -->
                                <div class="form-row">
                                    <label for="password">Nhập mật khẩu mới:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu mới">
                                    </div>
                                </div>
                                <?php
                                echo form_error('password', '<span class="error">', '</span>', $errors);
                                ?>
                                <div class="form-row">
                                    <label for="password_confirm">Nhập lại mật khẩu mới:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-redo-alt"></i>
                                        </span>
                                        <input name="password_confirm" type="password" class="form-control" id="password_confirm" placeholder="Nhập lại mật khẩu mới">
                                    </div>
                                </div>
                                <?php
                                echo form_error('password_confirm', '<span class="error">', '</span>', $errors);
                                ?>

                                <input type="hidden" name="token" value="<?php echo $token; ?>">

                                <!-- Nút Gửi -->
                                <div class="form-row text-center mt-3" style="width: 80px; text-align: center;">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-paper-plane"></i> Gửi
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
layouts('footer-login');
?>