<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$data = [
    'pageTitle' => 'Đổi mật khẩu'
];

layouts('header', $data);

if (!isLogin()) {
    redirect('?module=home&action=dashboard');
}


$session  = getSession();
$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$userDetail = oneRaw("SELECT * FROM users WHERE id=$userId");

if (isPost()) {
    $filterAll = filter();
    $errors = [];

    // Validate mật khẩu hiện tại
    if (empty($filterAll['current_password'])) {
        $errors['current_password']['required'] = 'Mật khẩu hiện tại là bắt buộc.';
    } elseif (!password_verify($filterAll['current_password'], $userDetail['password'])) {
        $errors['current_password']['invalid'] = 'Mật khẩu hiện tại không đúng.';
    }

    // Validate mật khẩu mới
    if (empty($filterAll['new_password'])) {
        $errors['new_password']['required'] = 'Mật khẩu mới là bắt buộc.';
    } elseif (strlen($filterAll['new_password']) < 8) {
        $errors['new_password']['min'] = 'Mật khẩu mới phải có ít nhất 8 ký tự.';
    }

    // Validate nhập lại mật khẩu
    if (empty($filterAll['confirm_password'])) {
        $errors['confirm_password']['required'] = 'Xác nhận mật khẩu mới là bắt buộc.';
    } elseif ($filterAll['new_password'] !== $filterAll['confirm_password']) {
        $errors['confirm_password']['match'] = 'Mật khẩu xác nhận không khớp.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($filterAll['new_password'], PASSWORD_DEFAULT);
        $updateStatus = update('users', ['password' => $hashedPassword], "id = $userId");

        if ($updateStatus) {
            setFlashData('smg', 'Đổi mật khẩu thành công!');
            setFlashData('smg_type', 'success');
            redirect('?module=users&action=changePassword');
        } else {
            setFlashData('smg', 'Có lỗi xảy ra, vui lòng thử lại.');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<div class="container mt-5" style="min-height: 522px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center text-uppercase mb-4">Đổi mật khẩu</h2>

            <!-- Display message -->
            <?php
            if (!empty($smg)) {
                getSmg($smg, $smg_type);
            }
            ?>

            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <div class="form-group">
                            <label for="current_password">
                                <i class="fas fa-key"></i> Mật khẩu hiện tại
                            </label>
                            <input type="password" name="current_password" class="form-control form-control-lg" placeholder="Nhập mật khẩu hiện tại" value="<?php echo $old['current_password'] ?? ''; ?>">
                            <?php echo form_error('current_password', '<span class="error text-danger">', '</span>', $errors); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password">
                                <i class="fas fa-lock"></i> Mật khẩu mới
                            </label>
                            <input type="password" name="new_password" class="form-control form-control-lg" placeholder="Nhập mật khẩu mới" value="<?php echo $old['new_password'] ?? ''; ?>">
                            <?php echo form_error('new_password', '<span class="error text-danger">', '</span>', $errors); ?>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">
                                <i class="fas fa-check-circle"></i> Xác nhận mật khẩu mới
                            </label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Nhập lại mật khẩu mới" value="<?php echo $old['confirm_password'] ?? ''; ?>">
                            <?php echo form_error('confirm_password', '<span class="error text-danger">', '</span>', $errors); ?>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg btn-block mt-2">
                            <i class="fas fa-sync-alt"></i> Cập nhật mật khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php layouts('footer'); ?>

<style>
    /* Custom styles */
    .error {
        font-size: 0.875rem;
        display: block;
        margin-top: 5px;
    }

    .card {
        border-radius: 10px;
    }

    .btn-lg {
        padding: 14px;
        font-size: 1.1rem;
    }

    .form-control-lg {
        font-size: 1.1rem;
        padding: 12px;
    }

    .text-danger {
        color: #dc3545;
    }

    .container {
        max-width: 750px;
    }

    .card-body {
        padding: 30px;
    }

    .fas {
        margin-right: 10px;
    }
</style>
