<?php
if (!defined('_CODE')) {
    die('Access denied...');
}


$data = [
    'pageTitle' => 'Thêm người dùng'
];

layouts('header', $data);


if (isPost()) {
    $filterAll = filter();

    $errors = []; // Mảng chữa các lỗi

    // Validate fullname: bắt buộc phải nhập, min 5 ký tự
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = 'Họ tên phải có ít nhất 5 ký tự.';
        }
    }


    // Email Validate: bắt buộc phải nhập, đúng đinh dạng email, kiểm tra email đã tồn tại trong csdl chưa
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập.';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if (getRows($sql) > 0) {
            $errors['email']['unique'] = 'Email đã tồn tại.';
        }
    }

    // Validate số điện thoại: bắt buộc phải nhập, số có đúng định dạng không
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập.';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
        }
    }

    // Validate password: bắt buộc phải nhập, >=8 ký tự
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = 'Mật khẩu phải lớn hơn hoặc bằng 8.';
        }
    }

    // Validate pasword_confirm: bắt buộc phải nhập, giống password
    if (empty($filterAll['password_confirm'])) {
        $errors['password_confirm']['required'] = 'Bạn phải nhập lại mật khẩu.';
    } else {
        if (($filterAll['password']) != $filterAll['password_confirm']) {
            $errors['password_confirm']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
        }
    }

    // Validate gender: bắt buộc phải chọn
    if (empty($filterAll['gender'])) {
        $errors['gender']['required'] = 'Giới tính bắt buộc phải chọn.';
    } elseif (!in_array($filterAll['gender'], ['Nam', 'Nữ'])) {
        $errors['gender']['invalid'] = 'Giới tính không hợp lệ.';
    }

    // Validate code: bắt buộc phải nhập, chỉ chứa chữ cái, số, dấu gạch dưới, >=5 ký tự
    if (empty($filterAll['code'])) {
        $errors['code']['required'] = 'Tài khoản bắt buộc phải nhập.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{5,}$/', $filterAll['code'])) {
        $errors['code']['format'] = 'Tài khoản phải có ít nhất 5 ký tự và chỉ chứa chữ cái, số hoặc dấu gạch dưới.';
    }
        
    // Validate role: bắt buộc phải chọn
    if (empty($filterAll['role'])) {
        $errors['role']['required'] = 'Vai trò bắt buộc phải chọn.';
    } elseif (!in_array($filterAll['role'], ['Quản trị viên', 'Người dùng'])) {
        $errors['role']['invalid'] = 'Vai trò không hợp lệ.';
    }

    // Validate dân tộc: bắt buộc phải nhập
    if (empty($filterAll['ethnic'])) {
        $errors['ethnic']['required'] = 'Dân tộc bắt buộc phải nhập.';
    }

    // Validate nơi cư trú: bắt buộc phải nhập
    if (empty($filterAll['permanent_residence'])) {
        $errors['permanent_residence']['required'] = 'Nơi cư trú bắt buộc phải nhập.';
    }

    // Validate chuyên ngành: bắt buộc phải nhập
    if (empty($filterAll['specialized'])) {
        $errors['specialized']['required'] = 'Chuyên ngành bắt buộc phải nhập.';
    }

    // Validate lớp: bắt buộc phải nhập
    if (empty($filterAll['class'])) {
        $errors['class']['required'] = 'Lớp bắt buộc phải nhập.';
    }
    
    
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar = $_FILES['avatar']; //name, tmp_name, size, error...
        $avatarPath = 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/';
        $avatarName = time() . '_' . $avatar['name']; // Đặt tên file ảnh để không bị trùng
        $avatarTmp = $avatar['tmp_name']; // Lấy tạm file ảnh
        
        // Di chuyển file ảnh từ tạm đến thư mục lưu trữ
        if (move_uploaded_file($avatarTmp, $avatarPath . $avatarName)) {
            // Nếu upload thành công, lưu đường dẫn ảnh
            $avatarUrl = $avatarPath . $avatarName;
        } else {
            // Nếu không thể tải ảnh lên, đưa ra lỗi
            $errors['avatar']['upload'] = 'Không thể tải ảnh lên.';
        }
    }

    if (empty($errors)) {

        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'role' =>$filterAll['role'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'gender' => $filterAll['gender'],
            'ethnic' => $filterAll['ethnic'],
            'class' => $filterAll['class'],
            'permanent_residence' => $filterAll['permanent_residence'],
            'specialized' => $filterAll['specialized'],
            'code' => $filterAll['code'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'avatar' => isset($avatarUrl) ? $avatarUrl : null,
            'create_at' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('users', $dataInsert);
        if ($insertStatus) {
            setFlashData('smg', 'Thêm người dùng mới thành công!!');
            setFlashData('smg_type', 'success');
            redirect('?module=home&action=dashboard');
        } else {
            setFlashData('smg', 'Hệ thống đang lỗi vui lòng thử lại sau.');
            setFlashData('smg_type', 'danger');
            redirect('?module=users&action=add');
        }
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu!!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
}


$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');



?>
<div class="container mt-4">
    <div class="row">
        <div class="content col-md-9">
            <div class="container">
                <div class="row" style="margin: 50px auto;">
                    <h2 class="text-center text-uppercase">Thêm người dùng</h2>
                    <?php
                    if (!empty($smg)) {
                        getSmg($smg, $smg_type);
                    }
                    ?>
                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                        <!-- Avatar -->
                        <div class="form-group mg-form">
                            <label for=""><i class="fas fa-image"></i> Ảnh đại diện</label>
                            <input name="avatar" type="file" class="form-control" accept="image/*">
                            <?php echo form_error('avatar', '<span class="error">', '</span>', $errors); ?>
                        </div>
                        <div class="row">
                            <!-- Cột trái -->
                            <div class="col">
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-user"></i> Họ tên</label>
                                    <input name="fullname" type="text" class="form-control" placeholder="Họ tên" value="<?php echo old('fullname', $old); ?>">
                                    <?php echo form_error('fullname', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-envelope"></i> Email</label>
                                    <input  name="email" type="email" class="form-control" placeholder="Địa chỉ email" value="<?php echo old('email', $old); ?>">
                                    <?php echo form_error('email', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input name="phone" type="text" class="form-control" placeholder="Số điện thoại" value="<?php echo old('phone', $old); ?>">
                                    <?php echo form_error('phone', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-venus-mars"></i> Giới tính</label>
                                    <select name="gender" class="form-control">
                                        <option value="Nam" <?php echo (old('gender', $old) == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo (old('gender', $old) == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                    </select>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-flag"></i> Dân tộc</label>
                                    <input name="ethnic" type="text" class="form-control" placeholder="Dân tộc" value="<?php echo old('ethnic', $old); ?>">
                                    <?php echo form_error('ethnic', '<span class="error">', '</span>', $errors); ?>
                                </div>
                            </div>
                            <!-- Cột phải -->
                            <div class="col">
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-user-circle"></i> Tài khoản</label>
                                    <input name="code" type="text" class="form-control" placeholder="Tài khoản" value="<?php echo old('code', $old); ?>">
                                    <?php echo form_error('code', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-lock"></i> Mật khẩu</label>
                                    <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
                                    <?php echo form_error('password', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-lock"></i> Nhập lại mật khẩu</label>
                                    <input name="password_confirm" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                                    <?php echo form_error('password_confirm', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-chalkboard"></i> Lớp</label>
                                    <input name="class" type="text" class="form-control" placeholder="Lớp" value="<?php echo old('class', $old); ?>">
                                    <?php echo form_error('class', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-graduation-cap"></i> Chuyên ngành</label>
                                    <input name="specialized" type="text" class="form-control" placeholder="Chuyên ngành" value="<?php echo old('specialized', $old); ?>">
                                    <?php echo form_error('specialized', '<span class="error">', '</span>', $errors); ?>
                                </div>
                            </div>
                        </div>
                        <!-- Hàng khác -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-home"></i> Nơi cư trú</label>
                                    <input name="permanent_residence" type="text" class="form-control" placeholder="Nơi cư trú" value="<?php echo old('permanent_residence', $old); ?>">
                                    <?php echo form_error('permanent_residence', '<span class="error">', '</span>', $errors); ?>
                                </div>
                                <div class="form-group mg-form">
                                    <label for=""><i class="fas fa-user-tag"></i> Vai trò</label>
                                    <select name="role" class="form-control">
                                        <option value="Quản trị viên" <?php echo (old('role', $old) == 'Quản trị viên') ? 'selected' : ''; ?>>Quản trị viên</option>
                                        <option value="Người dùng" <?php echo (old('role', $old) == 'Người dùng') ? 'selected' : ''; ?>>Người dùng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Nút -->
                        <button type="submit" class="btn btn-danger btn-block mt-5" style="width: 100px;">Đồng ý</button>
                        <a href="?module=home&action=dashboard" class="btn btn-secondary btn-block mt-5"   style="width: 100px;">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- Right Sidebar -->
        <div class="right-sidebar col-md-3">
            <!-- Reused Đăng Nhập section -->
            <div class="card shadow">
                <div class="card-header text-white text-center" style="background-color: #ad171c !important; border-color: #901317 !important; border: 1px solid #000; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h5 class="mb-0">ĐĂNG NHẬP</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="text-start">
                            <strong>Tài khoản:</strong> B21DCAT205
                        </div>
                        <div class="text-start">
                            <strong>Họ và tên:</strong> Lê Anh Tuấn
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
        </div>
    </div>
</div>




<?php
layouts('footer');
?>