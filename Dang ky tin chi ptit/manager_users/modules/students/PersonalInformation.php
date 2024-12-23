<?php

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Danh sách người dùng'
];

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&action=login');
}

// Truy vấn vào bảng users
$listUsers = getRaw("SELECT * FROM users ORDER BY update_at");

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

$session  = getSession();
$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

$code = '';
$fullname = '';
if ($userId == $user["id"]) {
    // User data
    $code = $user["code"]; // Mã sinh viên và mã admin
    $fullname = $user["fullname"];  // Họ và tên sinh viên và admin
    $birth_date = $user["birth_date"]; // Ngày sinh sinh viên và admin
    $gender = $user["gender"]; // Giới tính sinh viên và admin
    $email = $user["email"]; // Email sinh viên và admin
    $phone = $user["phone"]; // Số điện thoại sinh viên và admin
    $ethnic = $user["ethnic"]; // Dân tộc sinh viên và admin
    $citizen_identification = $user["citizen_identification"]; // Số CMND sinh viên và admin
    $permanent_residence = $user["permanent_residence"]; // Nơi sinh sinh viên và admin
    $specialized = $user["specialized"]; // Chuyên ngành sinh viên và admin
    $degree = $user["degree"]; // Bằng cấp sinh viên và admin
    $training_school = $user["training_school"]; // Trường đào tạo sinh viên và admin
    $professional_certifications = $user["professional_certifications"]; // Chứng chỉ sinh viên và admin
    $title = $user["title"]; // Chức danh sinh viên và admin
    $department = $user["department"]; // Khoa sinh viên và admin
    $rank = $user["rank"]; // Xếp loại sinh viên và admin
    $years_of_experience = $user["years_of_experience"]; // Số năm kinh nghiệm admin
    $class = $user["class"]; // Lớp sinh viên
    $religion = $user["religion"]; // Tôn giáo sinh viên và admin
    $status = $user["status"]; // Hiện diện sinh viên
    $training_level = $user["training_level"]; // Bậc hệ đào tạo sinh viên
    $school_year = $user["school_year"]; // Niên khóa sinh viên
    $role = $user["role"]; // Vai trò sinh viên và admin
    $gpa = $user["gpa"]; // Điểm trung bình sinh viên
    $registration_status = $user["registration_status"]; // Trạng thái đăng ký sinh viên
    $avatar = $user["avatar"]; // Ảnh đại diện sinh viên và admin
    $avatar = str_replace('C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/', '', $avatar);
}

?>

<div id="personal_page" class="section container" >
    <div class="row">
        <!-- Avatar Section -->
        <div class="col-md-4 text-center">
            <div class="card shadow-sm d-flex justify-content-center align-items-center">
                <img src="<?php echo $avatar; ?>" class="img-thumbnail rounded-circle" alt="Profile Picture" style="width: 250px; height: 250px; object-fit: cover;">
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="m-0"><i class="fa fa-user"></i> Thông tin sinh viên</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã SV:</strong> <?php echo $code; ?></p>
                            <p><strong>Họ và Tên:</strong> <?php echo $fullname; ?></p>
                            <p><strong>Ngày sinh:</strong> <?php echo $birth_date; ?></p>
                            <p><strong>Giới tính:</strong> <?php echo $gender; ?></p>
                            <p><strong>Điện thoại:</strong> <?php echo $phone; ?></p>
                            <p><strong>Số CMND/CCCD:</strong> <?php echo $citizen_identification; ?></p>
                            <p><strong>Email:</strong> <?php echo $email; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email 2:</strong> <?php echo $email; ?></p>
                            <p><strong>Nơi sinh:</strong> <?php echo $permanent_residence; ?></p>
                            <p><strong>Dân tộc:</strong> <?php echo $ethnic; ?></p>
                            <p><strong>Tôn giáo:</strong> <?php echo $religion; ?></p>
                            <p><strong>Hiện diện:</strong> <?php echo $status; ?></p>
                            <p><strong>Hộ khẩu:</strong> <?php echo $permanent_residence; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Course Information Section -->
    <div class="mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="m-0"><i class="fa fa-book"></i> Thông tin khóa học</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Lớp:</strong> <?php echo $class; ?></p>
                        <p><strong>Ngành:</strong> <?php echo $specialized; ?></p>
                        <p><strong>Chuyên ngành:</strong> <?php echo $specialized; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Khoa:</strong> <?php echo $department; ?></p>
                        <p><strong>Bậc hệ đào tạo:</strong> <?php echo $training_level; ?></p>
                        <p><strong>Niên khóa:</strong> <?php echo $school_year; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .card-body p {
        font-size: 14px;
        color: #333;
    }

    .card-body strong {
        color: #d9534f;
    }

    .img-thumbnail {
        border-radius: 50%;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .shadow-sm {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }
</style>