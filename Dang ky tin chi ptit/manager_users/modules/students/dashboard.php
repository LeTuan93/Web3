<?php

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


<div class="container mt-4" style="min-height: 547px;">
    <div class="row">
        <!-- Main Content Section -->
        <div class="content col-md-9">

            <!-- Internship Registration Section -->
            <?php include 'InternshipRegistration.php'; ?>
            
            <!-- Registration History Section -->

            <?php include 'RegistratrionHistory.php'; ?>

            <!-- View Scores Section -->
            <?php include 'ViewScores.php'; ?>
            
            <!-- Personal Information Section -->
            <?php include 'PersonalInformation.php'; ?>

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
                    <a href="<?php echo _WEB_HOST ?>/?module=auth&action=logout">
                        <button class="btn btn-danger w-100">Đăng Xuất</button>
                    </a>
                    <div class="mt-2">
                        <a href="?module=users&action=changePassword" class="text-muted" style="font-style: italic;">Đổi mật khẩu</a>
                    </div>
                </div>
            </div>

            <!-- Reused Tính Năng section -->
            <div class="card shadow mt-4">
                <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
                    <h5 class="mb-0">TÍNH NĂNG</h5>
                </div>
                <ul class="list-group">
                    <li class="list-group-item active " onclick="showSection('regyster_internship', this)" style="border-top-left-radius: 0px; border-top-right-radius:0px">
                        <i class="fas fa-angle-right"></i> Đăng ký thực tập
                    </li>
                    <li class="list-group-item" onclick="showSection('registration_history', this)">
                        <i class="fas fa-angle-right"></i> Lịch sử đăng ký
                    </li>
                    <li class="list-group-item" onclick="showSection('view_score', this)">
                        <i class="fas fa-angle-right"></i> Xem điểm số
                    </li>
                    <li class="list-group-item" onclick="showSection('personal_page', this)">
                        <i class="fas fa-angle-right"></i> Trang cá nhân
                    </li>
                </ul>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>


<?php
layouts('footer');
?>