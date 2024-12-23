<?php
if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Thông tin cá nhân'
];

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
    $avatar = $user["avatar"];
    $avatar = str_replace('C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/', '', $avatar);
}


// Xử lý thông tin cá nhân

$session = getSession();
$token = $session['logintoken'];

// Lấy thông tin user ID từ bảng logintoken
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

?>

<!-- Personal Information Section -->
<div id="personal_page" class="section mt-4" style="display: none;">
    <div class="container">
        <div class="row">
            <!-- Cột trái: Ảnh và thông tin cơ bản -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <img src="<?php echo $avatar; ?>" alt="Profile" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                        <h5 class="card-title mb-1"><?php echo $user['fullname']; ?></h5>
                        <p class="text-muted"><i class="fa fa-user-tie"></i> <?php echo $user['title']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    </div>
                </div>
                <div class="card shadow-sm mt-4">
                    <div class="card-header text-white" style="background-color: #ad171c;border-color: #901317 !important;">
                        <h6><i class="fa fa-briefcase"></i> Thông Tin Công Việc</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Chức danh:</strong> <?php echo $user['title']; ?></p>
                        <p><strong>Khoa:</strong> <?php echo $user['department']; ?></p>
                        <p><strong>Chức vụ:</strong> <?php echo $user['rank']; ?></p>
                        <p><strong>Số năm kinh nghiệm:</strong> <?php echo $user['years_of_experience']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Thông tin chi tiết -->
            <div class="col-lg-8">
                <!-- Thông tin cá nhân -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white" style="background-color: #ad171c;border-color: #901317 !important;">
                        <h6><i class="fa fa-user"></i> Thông Tin Cá Nhân</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Mã số:</strong> <?php echo $user['code']; ?></p>
                        <p><strong>Họ và tên:</strong> <?php echo $user['fullname']; ?></p>
                        <p><strong>Ngày sinh:</strong> <?php echo $user['birth_date']; ?></p>
                        <p><strong>Giới tính:</strong> <?php echo $user['gender']; ?></p>
                        <p><strong>Điện thoại:</strong> <?php echo $user['phone']; ?></p>
                        <p><strong>Số CMND/CCCD:</strong> <?php echo $user['citizen_identification']; ?></p>
                    </div>
                </div>

                <!-- Thông tin học thuật -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white" style="background-color: #ad171c;border-color: #901317 !important;">
                        <h6><i class="fa fa-graduation-cap"></i> Thông Tin Học Thuật</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Chuyên ngành:</strong> <?php echo $user['specialized']; ?></p>
                        <p><strong>Bậc học:</strong> <?php echo $user['degree']; ?></p>
                        <p><strong>Trường đào tạo:</strong> <?php echo $user['training_school']; ?></p>
                        <p><strong>Chứng chỉ nghề nghiệp:</strong> <?php echo $user['professional_certifications']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









