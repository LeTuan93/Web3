<?php
ob_start();
if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Trang chủ'
];

layouts('header', $data);

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
$session  = getSession();

$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

// Nếu người dùng là sinh viên thì chuyển hướng về trang sinh viên
if ($user['role'] == 'Người dùng') {
    redirect('?module=students&action=dashboard');
}

$code = '';
$fullname = '';
if ($userId == $user["id"]) {
    $code = $user["code"]; 
    $fullname = $user["fullname"];
}


?>


<div class="container mt-4" style="min-height: 547px;">
    <div class="row">
        <!-- Main Content Section -->
        <div class="content col-md-9">
            <!-- Personal Information Section -->
            <?php include "PersonalInformation.php"; ?>
            <!-- Student List Section -->
            <?php include "StudentList.php"; ?>
            <!-- Internship Registration Section -->
            <?php include "InternshipRegistrationList.php"; ?>
            <!-- Registration History Section -->
            <?php include "RegistratrionHistory.php"; ?>
            <!-- Statistic Section -->
            <?php include "Statistic.php"; ?>
        </div>

        <!-- Right Sidebar -->
        <div class="right-sidebar col-md-3">
            <div class="card shadow">
                <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
                    <h5 class="mb-0">ĐĂNG NHẬP</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="text-start">
                            <strong>Tài khoản:</strong> <?php echo $code ?>
                        </div>
                        <div class="text-start">
                            <strong>Họ và tên:</strong> <?php echo $fullname ?>
                        </div>
                    </div>
                    <a href="<?php echo _WEB_HOST?>/?module=auth&action=logout">
                        <button class="btn btn-danger w-100">Đăng Xuất</button>
                    </a>
                    <div class="mt-2">
                        <a href="<?php echo _WEB_HOST?>/?module=users&action=changePassword" class="text-muted" style="font-style: italic;">Đổi mật khẩu</a>
                    </div>
                </div>
            </div>

            <!-- Reused Tính Năng section -->
            <div class="card shadow mt-4">
                <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
                    <h5 class="mb-0">TÍNH NĂNG</h5>
                </div>
                <ul class="list-group">
                    <li class="list-group-item" onclick="showSection('regyster_internship', this)">
                            <i class="fas fa-angle-right"></i> Yêu cầu thực tập
                    </li>
                    <li class="list-group-item active " onclick="showSection('view_score', this)" style="border-top-left-radius: 0px; border-top-right-radius:0px">
                            <i class="fas fa-angle-right"></i> Danh sách sinh viên
                    </li>
                    <li class="list-group-item" onclick="showSection('registration_history', this)">
                        <i class="fas fa-angle-right"></i> Lịch sử đăng ký
                    </li>
                    <li class="list-group-item" onclick="showSection('personal_page', this)">
                        <i class="fas fa-angle-right"></i> Thông tin cá nhân
                    </li>
                    <li class="list-group-item" onclick="showSection('statistic', this)">
                        <i class="fas fa-angle-right"></i> Thống kê
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php
layouts('footer');
ob_end_flush();
?>