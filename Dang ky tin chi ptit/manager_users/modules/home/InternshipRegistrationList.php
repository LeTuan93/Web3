<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Kiểm tra trạng thái đăng nhập
if (!isLogin()) {
    redirect('?module=auth&action=login');
    exit();
}

// Xử lý duyệt yêu cầu
if (isset($_GET['approve_id']) && isset($_GET['confirm_approve']) && $_GET['confirm_approve'] == 'yes') {
    $approveId = intval($_GET['approve_id']);
    $update = update('registration', ['status' => 'Đã duyệt'], "id = $approveId");

    if ($update) {
        setFlashData('message', 'Duyệt thành công!');

        // users có 3 bản ghi yêu cầu trong registration, khi duyệt thành công 1 bản ghi thì các bản ghi còn lại sẽ bị xóa trong registration
        $registrationDetail = getRaw('SELECT * FROM registration WHERE id = ' . $approveId);
        $userId= $registrationDetail[0]['user_id'];
        delete('registration', "user_id = $userId AND status = 'Chưa duyệt' ");

        // Trong bảng companies cập nhật registered_slots
        $companyId = $registrationDetail[0]['company_id'];
        $companyDetail = oneRaw('SELECT * FROM companies WHERE id = ' . $companyId);
        $companyDetail['registered_slots'] = $companyDetail['registered_slots'] + 1;
        $dataUpdate = [
            'registered_slots' => $companyDetail['registered_slots']
        ];
        update('companies', $dataUpdate, 'id = ' . $companyId);
    
    } else {
        setFlashData('message', 'Có lỗi xảy ra khi duyệt yêu cầu.');
    }

    // Redirect và dừng thực thi mã
    redirect('?module=home&action=dashboard');
    exit();
}

// Lấy thông tin lọc và sắp xếp từ request
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'student_code';
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC';

// Tạo điều kiện lọc
$sqlSearch = '';
if (!empty($search)) {
    $sqlSearch .= "AND (users.code LIKE '%$search%' OR companies.name LIKE '%$search%' OR users.specialized LIKE '%$search%' OR users.gpa LIKE '%$search%' OR registration.status LIKE '%$search%')";
}

// Truy vấn danh sách yêu cầu đăng ký
$listRegistrations = getRaw("
    SELECT registration.*, users.code AS student_code, users.fullname AS student_name, 
           users.specialized AS student_major, users.gpa AS student_gpa, 
           companies.name AS company_name, companies.address AS company_address
    FROM registration
    JOIN users ON registration.user_id = users.id
    JOIN companies ON registration.company_id = companies.id
    WHERE 1=1 $sqlSearch
    ORDER BY $sort_by $order
");

$message = getFlashData('message');

?>
<!-- Internship Registration Section -->
<div id="regyster_internship" class="section" style="display: none;">
    <h5 class="text-danger"><i class="fa fa-check"></i> Duyệt Yêu Cầu Thực Tập</h5>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Thanh tìm kiếm -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã SV, tên công ty, ngành, GPA, trạng thái..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-danger" style="width: 100px;">Tìm kiếm</button>
        </div>
    </form>
    
    <!-- Điều kiện lọc và sắp xếp -->
    <form method="GET" class="d-flex mb-3 align-items-center">
        <!-- Duy trì giá trị tìm kiếm -->
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">

        <div class="me-3">
            <label for="sort_by" class="form-label">Sắp xếp theo</label>
            <select name="sort_by" id="sort_by" class="form-select">
                <option value="student_code" <?php echo $sort_by === 'student_code' ? 'selected' : ''; ?>>Mã sinh viên</option>
                <option value="priority" <?php echo $sort_by === 'priority' ? 'selected' : ''; ?>>Thứ tự nguyện vọng</option>
                <option value="student_name" <?php echo $sort_by === 'student_name' ? 'selected' : ''; ?>>Tên sinh viên</option>
                <option value="student_major" <?php echo $sort_by === 'student_major' ? 'selected' : ''; ?>>Ngành</option>
                <option value="student_gpa" <?php echo $sort_by === 'student_gpa' ? 'selected' : ''; ?>>GPA</option>
                <option value="company_name" <?php echo $sort_by === 'company_name' ? 'selected' : ''; ?>>Tên công ty</option>
                <option value="status" <?php echo $sort_by === 'status' ? 'selected' : ''; ?>>Trạng thái</option>
            </select>
        </div>

        <div class="me-3">
            <label for="order" class="form-label">Thứ tự</label>
            <select name="order" id="order" class="form-select">
                <option value="asc" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Tăng dần</option>
                <option value="desc" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Giảm dần</option>
            </select>
        </div>

        <div class="me-3 align-self-end">
            <button type="submit" class="btn btn-danger">Lọc</button>
        </div>
    </form>
    
    <!-- Danh sách đăng ký -->
    <table class="table table-striped table-bordered mb-4">
        <thead class="bg-primary text-white">
            <tr class="text-center align-middle">
                <th scope="col">STT</th>
                <th scope="col">Mã <br>Sinh Viên</th>
                <th scope="col">Tên <br>Sinh Viên</th>
                <th scope="col">Ngành</th>
                <th scope="col">Tên Công Ty</th>
                <th scope="col">Địa Chỉ</th>
                <th scope="col">GPA</th>
                <th scope="col">Thứ Tự Nguyện Vọng</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($listRegistrations)):
                $count = 0;
                foreach ($listRegistrations as $item):
                    $count++;
            ?>
                <tr>
                    <td class="text-center"><?php echo $count; ?></td>
                    <td><?php echo $item['student_code']; ?></td>
                    <td ><?php echo $item['student_name']; ?></td>
                    <td><?php echo $item['student_major']; ?></td>
                    <td><?php echo $item['company_name']; ?></td>
                    <td><?php echo $item['company_address']; ?></td>
                    <!-- //gpa nếu như là null thì sẽ là 0.000 -->
                    <td class="text-center"><?php echo $item['student_gpa'] ?? 0; ?></td>
                    <td class="text-center"><?php echo $item['priority']; ?></td>
                    <td class="text-center">
                        <?php
                        if ($item['status'] === 'Chưa duyệt') {
                            echo '<span class="badge bg-danger-subtle text-dark">Chưa duyệt</span>';
                        } else {
                            echo '<span class="badge bg-success-subtle text-dark">Đã duyệt</span>';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php if ($item['status'] === 'Chưa duyệt'): ?>
                            <button type="button" class="btn btn-success" onclick="showModal(<?php echo $item['id']; ?>)">Duyệt</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="10" class="text-center">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<!-- Modal xác nhận (hộp thoại)-->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Xác Nhận Duyệt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn duyệt yêu cầu này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="" id="confirmApproveBtn" class="btn btn-primary">Xác Nhận</a>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(id) {
        const confirmUrl = '?module=home&action=dashboard&approve_id=' + id + '&confirm_approve=yes';
        document.getElementById('confirmApproveBtn').href = confirmUrl;
        var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        myModal.show();
    }
</script>