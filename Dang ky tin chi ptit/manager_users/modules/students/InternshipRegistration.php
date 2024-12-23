<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&action=login');
}

//Truy vấn vào bảng companies
$listCompanies = getRaw("SELECT * FROM companies ORDER BY update_at");


//Lấy thông tin người dùng đang đăng nhập
$session  = getSession();
$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<!-- Internship Registration Section -->
<div id="regyster_internship" class="section" >
    <h5 class="text-danger"><i class="fa fa-building"></i> Đăng ký thực tập công ty</h5>
    <?php
    if (!empty($smg)) {
        getSmg($smg, $smg_type);
    }
    ?>
    <form id="internship-form" method="POST" action="?module=users&action=register">
        <input type="hidden" name="preferences" id="preferences-hidden">
        <table class="table table-striped table-bordered mb-4">
            <thead class="bg-danger text-white text-center">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên Công Ty</th>
                    <th scope="col">Địa Chỉ</th>
                    <th scope="col">Tổng số lượng</th>
                    <th scope="col">Số lượng còn lại</th>
                    <th scope="col">Thứ tự nguyện vọng</th>
                    <th scope="col">Đăng ký</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($listCompanies)):
                    $count = 0;
                    foreach ($listCompanies as $item):
                        $count++;
                ?>
                        <tr>
                            <td class="text-center"><?php echo $count; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['address']; ?></td>
                            <td class="text-center"><?php echo $item['total_slots']; ?></td>
                            <td class="text-center"><?php echo $item['total_slots'] - $item['registered_slots']; ?></td>
                            <td class="text-center preference-order" data-company-id="<?php echo $item['id']; ?>">--</td>
                            <td class="text-center">
                                <input type="checkbox"
                                    class="toggle-preference"
                                    value="<?php echo $item['id']; ?>"
                                    data-company-id="<?php echo $item['id']; ?>">
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-danger text-center">Không có dữ liệu</div>
                        </td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-danger" id="submit-preferences" style="width: 100px;" disabled>Submit</button>
        </div>
    </form>

</div>