<?php

if (!defined('_CODE')) {
    die('Access denied');
}

if (!isLogin()) {
    redirect('?module=auth&action=login');
}
$session  = getSession();
// từ thông tin session có 2 thông tin
// [tokenLogin] => 4a95ae2b3263d7b2bc96b57a3512dc1bbfda6a44
// [logintoken] => fa3fe45c273bee53b591ffb1cf38ab05e65d2d0d
// lấy  value của thông tin logintoken và truy vấn trong bảng logintoken để tìm id người dùng đang đăng nhập từ bảng logintoken (truy vấn) 
// sau đó lấy id người dùng đó để truy vấn trong bảng users

$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");
$code = '';
$fullname = '';
if ($userId == $user["id"]) {
    $code = $user["code"]; 
    $fullname = $user["fullname"];
    $gender = $user["gender"];
    $email = $user["email"];
    $permanent_residence = $user["permanent_residence"];
    $specialized = $user["specialized"];
    $degree = $user["degree"];
    $training_school = $user["training_school"];
    $professional_certifications = $user["professional_certifications"];
    $title = $user["title"];
    $department = $user["department"];
    $rank = $user["rank"];
    $years_of_experience = $user["years_of_experience"];
}

?>

<!-- Reused Đăng Nhập section -->
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
            <a href="#" class="text-muted" style="font-style: italic;">Đổi mật khẩu</a>
        </div>
    </div>
</div>

<!-- Reused Tính Năng section -->
<div class="card shadow mt-4">
    <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
        <h5 class="mb-0">TÍNH NĂNG</h5>
    </div>
    <ul class="list-group">
        <li class="list-group-item" onclick="showSection('personal_page', this)">
            <!-- <a href="?module=home&action=dashboard"> -->
                <i class="fas fa-angle-right"></i> Trang cá nhân
            <!-- </a> -->
        </li>
        <li class="list-group-item active " onclick="showSection('regyster_internship', this)" style="border-top-left-radius: 0px; border-top-right-radius:0px">
            <!-- <a href="?module=home&action=InternshipRegistrationList"> -->
                <i class="fas fa-angle-right"></i> Danh sách đăng ký thực tập
            <!-- </a> -->
        </li>
        <li class="list-group-item" onclick="showSection('view_score', this)">
            <!-- <a href="?module=home&action=InternshipRegistrationList"> -->
                <i class="fas fa-angle-right"></i> Thống kê
            <!-- </a> -->
        </li>
        <li class="list-group-item" onclick="showSection('registration_history', this)">
            <!-- <a href="?module=home&action=InternshipRegistrationList"> -->
                <i class="fas fa-angle-right"></i> Lịch sử đăng ký
            <!-- </a> -->
        </li>

        <li class="list-group-item" onclick="showSection('statistic', this)">
            <!-- <a href="?module=home&action=dashboard"> -->
                <i class="fas fa-angle-right"></i> Thống kê
            <!-- </a> -->
        </li>
    </ul>
</div>