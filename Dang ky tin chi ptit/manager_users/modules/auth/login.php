<?php

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Đăng nhập tài khoản'
];

layouts('header-login', $data);

//Kiểm tra trạng thái đăng nhập

if (isLogin()){
    redirect('?module=home&action=dashboard');
}

if (isPost()) {
    $filterAll = filter();
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
                $tokenLogin = sha1(uniqid().time());

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
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

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
    <div class="row mt-4 ">
        <!-- Notification Section -->
        <div class="col-md-9 ps-0">
            <div class="row shadow">
                <div class="text-white py-2 rounded-top" style="background-color: #ad171c !important; border-color: #901317 !important;border: 1px solid #000; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h5 class="mb-0 ms-3">THÔNG BÁO</h5>
                </div>
                <div class="row ms-1">
                    <!-- Main Announcement (Left Column) -->
                    <div class="col-md-5 mt-1 ps-0">
                        <!-- Large Announcement Image -->
                        <div class="row ">
                            <img src="<?php echo _WEB_HOST_TEMPLATES; ?>/image/Announcement_Image.png" class="img-fluid rounded-start" alt="Announcement Image" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="row">
                            <h5 class="card-title fw-bold" style="color: #b71c1c;">Thông Báo Từ Phòng Giáo Vụ</h5>
                            <p class="card-text">V/v Đăng ký thời khóa biểu các lớp học phần trong đợt học lớp riêng học kỳ I - năm học 2024-2025. <span class="badge bg-danger">New</span></p>
                        </div>
                    </div>

                    <!-- List of Smaller Announcements (Right Column) -->
                    <div class="col-md-7 mt-1 pe-0">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/V Mở hệ thống Đăng ký chuyên ngành D21VT</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/v: Điều chỉnh hình thức thực hiện các học phần thay thế tốt nghiệp cho sinh viên ngành Công nghệ Đa phương tiện khóa 2020 đại học hệ chính quy </span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/v: Tổ chức các lớp học lại, học cải thiện điểm theo lớp riêng - học kỳ 1, năm học 2024-2025 cho sinh viên các lớp Đại học chính quy </span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/v: Điều chỉnh hình thức thực hiện các học phần thay thế tốt nghiệp cho sinh viên khóa 2020 đại học hệ chính quy </span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/v: Danh sách sinh viên trả nợ đủ điều kiện xét tốt nghiệp đợt tháng 10/2024</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo: V/v Ban hành Kế hoạch thi lần 2 học kỳ 2, học kỳ phụ năm học 2023-2024</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo V/v: Đăng ký thực hiện khối kiến thức tốt nghiệp các ngành khối kỹ thuật khóa 2020</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo: V/v Tổ chức đăng ký học ghép – học kỳ 1 năm học 2024-2025</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-angle-right me-2"></i>Thông báo: Mở hệ thống đăng ký môn học học kỳ 1 năm học 2024-2025</span>
                                <span class="badge bg-danger">New</span>
                            </li>
                            <!-- More announcements can be added here -->
                        </ul>
                    </div>
                </div>
                
            </div>
            <div class="row shadow mt-3">
                <div class="text-white py-2 " style="background-color: #ad171c !important; border-color: #901317 !important;border: 1px solid #000; border-top-left-radius: 10px; border-top-right-radius: 10px;" >
                    <h5 class="mb-0 ms-3">HƯỚNG DẪN SỬ DỤNG</h5>
                </div>
                <div class="row ms-1 mt-3">
                    <!-- Instruction Section -->
                    <div class="col-md-7">
                        <ul class="list-unstyled">
                            <li class="mb-4">
                                <h5 class="text-danger">Bước 1:</h5>
                                <p>
                                    <strong>Nhận tài khoản</strong>
                                    <br>Mỗi sinh viên được cấp một tài khoản với tài khoản và mật khẩu mặc định là mã số sinh viên.
                                </p>
                            </li>
                            <li class="mb-4">
                                <h5 class="text-danger">Bước 2:</h5>
                                <p>
                                    <strong>Gửi yêu cầu</strong>
                                    <br>Sinh viên đăng nhập, điền biểu mẫu yêu cầu và nộp trên hệ thống online.
                                </p>
                            </li>
                            <li class="mb-4">
                                <h5 class="text-danger">Bước 3:</h5>
                                <p>
                                    <strong>Xử lý yêu cầu</strong>
                                    <br>Cơ quan, đơn vị nhận yêu cầu online, xử lý và thông báo qua email khi hoàn thành.
                                </p>
                            </li>
                            <li class="mb-4">
                                <h5 class="text-danger">Bước 4:</h5>
                                <p>
                                    <strong>Nhận kết quả</strong>
                                    <br>Khi nhận được thông báo yêu cầu xử lý thành công, sinh viên lên văn phòng cơ quan, đơn vị thực hiện xử lý để nhận kết quả.
                                </p>
                            </li>
                        </ul>
                    </div>
                
                    <!-- Images Section -->
                    <div class="col-md-5">
                            <img src="<?php echo _WEB_HOST_TEMPLATES; ?>/image/Game_Group.jpg" class="img-fluid" alt="Image 1">
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Login Section -->
        <div class="col-md-3 ">
            <div class="card shadow">
                <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000;">
                    <h5 class="mb-0">ĐĂNG NHẬP</h5>
                </div>
                <div class="card-body">
                    <form action ="" method ="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <!-- Icon for code -->
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input name = "code" type="text" class="form-control" id="code" placeholder="Nhập tài khoản" autocomplete="off">
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
                            if (!empty($msg)) {
                                getSmg($msg, $msg_type);
                            }
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