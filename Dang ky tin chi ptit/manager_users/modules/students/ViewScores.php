<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Kiểm tra trạng thái đăng nhập
if (!isLogin()) {
    redirect('?module=auth&action=login');
}

$session  = getSession();
$token = $session['logintoken'];
$userId = oneRaw("SELECT user_id FROM logintoken WHERE token='$token'")['user_id'];
$user = oneRaw("SELECT * FROM users WHERE id=$userId");

$listGrades = getRaw("SELECT * FROM grade WHERE user_id = $userId");
//Tính trung bình GPA
$gpa_4_avg = 0;
$gpa_10_avg = 0;
$credit_sum = 0;

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<div id="view_score" class="section">
    <h5 class="text-danger"><i class="fa fa-cogs"></i> XEM ĐIỂM</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-danger text-white">
                <tr class="text-center">
                    <th>STT</th>
                    <th>Mã MH</th>
                    <th>Nhóm/tổ môn học</th>
                    <th>Tên môn học</th>
                    <th>Số tín chỉ</th>
                    <th>Điểm thi</th>
                    <th>Điểm TK (10)</th>
                    <th>Điểm TK (4)</th>
                    <th>Điểm TK (C)</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($listGrades)):
                    $count = 0;
                    foreach ($listGrades as $item):
                        $count++;
                        // trong bảng grade có trường subject_id 
                        $subject_id = $item['subject_id'];
                        $subjectDetail = oneRaw('SELECT * FROM subject WHERE id = ' . $subject_id);

                        $final_exam_score = $item['final_exam_score']; 
                        
                        // sử dụng hàm convertGpa10 để chuyển điểm từ hệ 10 sang hệ 4
                        $gpa_10 = $item['gpa_10']; // điểm hệ 10
                        $result = convertGpa10($gpa_10);
                        $gpa_4 = $result['gpa_4']; // GPA hệ 4
                        $gpa_c = $result['gpa_c']; // Grade ký tự
                        
                        // Cộng dồn các giá trị
                        $gpa_4_avg += $gpa_4;
                        $gpa_10_avg += $gpa_10;
                        $credit_sum += $subjectDetail['credit'];
                ?>
                        <tr class="text-center">
                            <td><?php echo $count; ?></td>
                            <td><?php echo $subjectDetail['code']; ?></td>
                            <td><?php echo $subjectDetail['subject_group']; ?></td>
                            <td><?php echo $subjectDetail['name']; ?></td>
                            <td><?php echo $subjectDetail['credit']; ?></td>
                            <td><?php echo number_format($final_exam_score, 1); ?></td>
                            <td><?php echo number_format($gpa_10, 1); ?></td>
                            <td><?php echo number_format($gpa_4, 1); ?></td>
                            <td><?php echo $gpa_c; ?></td>
                            <td>
                                <?php
                                if ($gpa_c == 'F') {
                                    echo '<i class="fa fa-times text-danger"></i>';
                                } else {
                                    echo '<i class="fa fa-check text-success"></i>';
                                }
                                ?> 
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    
                    // Tính trung bình GPA sau vòng lặp
                    $gpa_4_avg = $gpa_4_avg / $count;
                    $gpa_10_avg = $gpa_10_avg / $count;
                    
                    $dataUpdate = [
                        'gpa'=> $gpa_4_avg
                    ];
                    $condition = "id = $userId";
                    update('users', $dataUpdate,$condition);
                else:
                    ?>
                    <td colspan="10">
                        <div class="alert alert-danger text-center">Không có dữ liệu</div>
                    </td>
                <?php
                endif;
                ?>
                <!-- Additional rows as needed -->
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <p>- Điểm trung bình tích lũy hệ 4: <strong class="text-danger"><?php echo number_format($gpa_4_avg, 2); ?></strong></p>
        <p>- Điểm trung bình tích lũy hệ 10: <strong class="text-danger"><?php echo number_format($gpa_10_avg, 2); ?></strong></p>
        <p>- Số tín chỉ tích lũy: <strong class="text-danger"><?php echo $credit_sum; ?></strong></p>
    </div>
</div>
