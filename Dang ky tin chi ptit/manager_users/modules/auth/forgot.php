<?php

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Quên mật khẩu'
];

layouts('header-login', $data);


$msgLogin = $msgForgot = '';
$msg_typeLogin = $msg_typeForgot = '';

// Kiểm tra xem form nào được submit
if (isPost()) {
    $filterAll = filter();
    $action = $filterAll['action'] ?? '';

    if ($action === 'login') {
        if (!empty(trim($filterAll['code'])) && !empty(trim($filterAll['password']))) {
            // Kiểm tra đăng nhập
            $code = $filterAll['code'];
            $password = $filterAll['password'];

            //Truy vấn lấy thông tin users theo code
            $userQuery = oneRaw("SELECT password,id FROM users WHERE code = '$code'");

            if (!empty($userQuery)) {
                $passwordHash = $userQuery["password"];
                $userId = $userQuery["id"];
                if (password_verify($password, $passwordHash)) {
                    //Tạo token login
                    $tokenLogin = sha1(uniqid() . time());

                    // insert vào bảng loginToken
                    $dataInsert = [
                        'user_id' => $userId,
                        'token' => $tokenLogin,
                        'create_at' => date('Y-m-d H:i:s')
                    ];

                    $insertStatus = insert('logintoken', $dataInsert);
                    if ($insertStatus) {
                        //Đăng nhập thành công
                        //Lưu cái loginToken vào session
                        setSession('logintoken', $tokenLogin);
                        redirect('?module=home&action=dashboard');
                    } else {
                        setFlashData('msg', 'Đăng nhập thất bại');
                        setFlashData('msg_type', 'danger');
                    }
                } else {
                    setFlashData('msg', 'Mật khẩu không chính xác');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Tài khoản không tồn tại');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Vui lòng nhập tài khoản và mật khẩu.');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    } else if ($action === 'forgot_password') {
        // Xử lý form quên mật khẩu
        $email = trim($filterAll['email'] ?? '');

        if (!empty($email)) {
            $queryUser = oneRaw("SELECT id FROM users WHERE email = '$email'");

            if (!empty($queryUser)) {
                $userId = $queryUser['id'];
                $forgotToken = sha1(uniqid() . time());
                $dataUpdate = [
                    'forgotToken' => $forgotToken
                ];

                if (update('users', $dataUpdate, "id = $userId")) {
                    $linkReset = _WEB_HOST . "?module=auth&action=reset&token=$forgotToken";

                    $subject = 'Yêu cầu khôi phục mật khẩu';
                    $content = "Chào bạn, <br>Bạn đã yêu cầu khôi phục mật khẩu tại hệ thống. Vui lòng click vào link sau để đổi mật khẩu: <br>$linkReset<br>Trân trọng cảm ơn.";

                    if (!sendMail($email, $subject, $content)) {
                        $msgForgot = 'Vui lòng kiểm tra email để khôi phục mật khẩu.';
                        $msg_typeForgot = 'success';
                    } else {
                        $msgForgot = 'Lỗi hệ thống, vui lòng thử lại sau.';
                        $msg_typeForgot = 'danger';
                    }
                } else {
                    $msgForgot = 'Lỗi hệ thống, vui lòng thử lại sau.';
                    $msg_typeForgot = 'danger';
                }
            } else {
                $msgForgot = 'Email không tồn tại trong hệ thống.';
                $msg_typeForgot = 'danger';
            }
        } else {
            $msgForgot = 'Vui lòng nhập email.';
            $msg_typeForgot = 'danger';
        }
    }
}

?>

<!-- Main Content Section -->
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
        <!-- Notification Section -->
        <div class="col-md-9 ps-0">
            <div class="row shadow">
                <div class="text-white py-2 rounded-top " style="background-color: #ad171c !important; border-color: #901317 !important;border: 1px solid #000;">
                    <h5 class="mb-0 ms-3">LẤY LẠI MẬT KHẨU</h5>
                </div>
                <div class="row ms-1" style="min-height: 257px;">
                    <!-- Main Announcement (Left Column) -->
                    <div class="card-body">
                        <form action="" method="post" class="d-flex flex-column justify-content-center align-items-center">
                            <input type="hidden" name="action" value="forgot_password">
                            <!-- Email đăng ký -->
                            <div class="form-row d-flex justify-content-center align-items-center" style="width: 100%;">
                                <label for="email" style="width: 400px;">Email đã đăng ký trong hệ thống:</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-at"></i>
                                    </span>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email">
                                </div>
                            </div>
                            <div class="mt-3"></div>
                            <?php
                            if (!empty($msgForgot))
                                getSmg($msgForgot, $msg_typeForgot);
                            ?>
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

        <!-- Login Section -->
        <div class="col-md-3 ">
            <div class="card shadow">
                <div class="card-header text-white text-center rounded-top" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
                    <h5 class="mb-0">ĐĂNG NHẬP</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <div class="input-group">
                                <!-- Icon for code -->
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input name="code" type="text" class="form-control" id="code" placeholder="Nhập tài khoản" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <!-- Icon for Password -->
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" autocomplete="new-password">
                                <!-- Toggle Password Visibility Icon -->
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <?php
                        if (!empty($msgLogin))
                            getSmg($msgLogin, $msg_typeLogin);
                        ?>
                        <!-- Nút đăng nhập -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                        </div>

                        <!-- Liên kết quên mật khẩu -->
                        <div class="text-center">
                            <a href="?module=auth&action=forgot" class="text-muted">Quên mật khẩu?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

layouts('footer-login');
?>