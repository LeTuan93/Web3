<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&action=login');
}

//Truy vấn vào bảng users
$listUsers = getRaw("SELECT * FROM users ORDER BY update_at");

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<!-- Liệt kê danh sách sinh viên -->
<div id="view_score" class="section" style="display: none;">
    <h5 class="text-danger"><i class="fa fa-building"></i> Danh sách sinh viên</h5>
    <p>
        <a href="?module=users&action=add" class="btn btn-danger btn-sm">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
    </p>
    <?php
    if (!empty($smg)) {
        getSmg($smg, $smg_type);
    }
    ?>
    <table class="table table-striped table-bordered mb-4">
        <thead class="bg-danger text-white">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Dân tộc</th>
                <th scope="col">Lớp</th>
                <th scope="col">Ngành</th>
                <th width="10%">Sửa</th>
                <th width="10%">Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($listUsers)):
                $count = 0;
                foreach ($listUsers as $item):
                    $count++;
            ?>
                    <tr>
                        <td> <?php echo $count; ?></td>
                        <td><?php echo $item['fullname'] ?></td>
                        <td><?php echo $item['email'] ?></td>
                        <td><?php echo $item['phone'] ?></td>
                        <td><?php echo $item['gender'] ?></td>
                        <td><?php echo $item['ethnic'] ?></td>
                        <td><?php echo $item['class'] ?></td>
                        <td><?php echo $item['specialized'] ?></td>
                        <td><a href="<?php echo _WEB_HOST ?>?module=users&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href="<?php echo _WEB_HOST ?>?module=users&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                <?php
                endforeach;
            else:
                ?>
                <td colspan="10">
                    <div class="alert alert-danger text-center">Không có dữ liệu</div>
                </td>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>