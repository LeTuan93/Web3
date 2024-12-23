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

//Truy vấn vào bảng registration
$listRegistrations = getRaw("SELECT * FROM registration ORDER BY create_at");

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<div id="registration_history" class="section" style="display: none;">
    <h5 class="text-danger"><i class="fa fa-history"></i> Lịch sử đăng ký</h5>
    <table class="table table-striped table-bordered mb-4">
        <thead class="bg-danger text-white">
            <tr class = "text-center align-middle">
                <th scope="col">STT</th>
                <th scope="col" style="width:250px">Tên Công Ty</th>
                <th scope="col" style="width:250px">Địa Chỉ</th>
                <th scope="col">Mã <br>sinh viên</th>
                <th scope="col">Tên <br>sinh viên</th>
                <th scope="col" style="width:140px">Thứ Tự <br> Nguyện Vọng</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Thời Gian <br>Đăng Ký</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            if (!empty($listRegistrations)):
                $count = 0;
                foreach ($listRegistrations as $item):
                    $count++;
                    // trong bảng registration có trường company_id, user_id hãy lấy nó
                    $user_id = $item['user_id'];
                    $userDetail = oneRaw('SELECT * FROM users WHERE id = ' . $user_id);
                    $company_id = $item['company_id'];
                    $company_name = getRaw('SELECT name FROM companies WHERE id = ' . $company_id)[0]['name'];
                    $company_address = getRaw('SELECT address FROM companies WHERE id = '. $company_id)[0]['address'];
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td class="text-justify"><?php echo $company_name; ?></td>
                        <td class="text-justify"><?php echo $company_address; ?></td>
                        <td><?php echo $userDetail['code']; ?></td>
                        <td><?php echo $userDetail['fullname']; ?></td>
                        <td class ='text-center'><?php echo $item['priority']; ?></td>
                        <td class="text-center">
                            <?php
                            if ($item['status'] == 'Chưa duyệt') {
                                echo '<span class="badge bg-danger-subtle text-dark">Chưa duyệt</span>';
                            } else {
                                echo '<span class="badge bg-success-subtle text-dark">Đã duyệt</span>';
                            }
                            ?>
                        </td>
                        <td class="text-justify"><?php echo $item['create_at']; ?></td>
                    </tr>
                <?php
                endforeach;
            else:
                ?>
                <td colspan="8">
                    <div class="alert alert-danger text-center">Không có dữ liệu</div>
                </td>
            <?php
            endif;
            ?>
            <!-- Thêm các dòng khác theo yêu cầu -->
        </tbody>
    </table>
</div>