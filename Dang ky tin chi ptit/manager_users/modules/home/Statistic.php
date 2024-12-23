<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&action=login');
}

// Thống kê số sinh viên đã đăng ký và chưa đăng ký
$totalRegistered = oneRaw("SELECT COUNT(*) as count FROM users WHERE registration_status = 1 AND role = 'Người dùng'")['count'];
$totalNotRegistered = oneRaw("SELECT COUNT(*) as count FROM users WHERE registration_status = 0 AND role = 'Người dùng'")['count'];

// Thống kê số sinh viên nam và nữ
$totalMale = oneRaw("SELECT COUNT(*) as count FROM users WHERE gender = 'Nam'")['count'];
$totalFemale = oneRaw("SELECT COUNT(*) as count FROM users WHERE gender = 'Nữ'")['count'];

// Thống kê số sinh viên chọn mỗi công ty
$companyStats = getRaw("SELECT company_id, COUNT(*) as count FROM registration GROUP BY company_id"); //[['company_id' => 1, 'count' => 10]]

// Tạo mảng để lưu thông tin tên công ty và số lượng sinh viên
$companyNames = [];
$companyCounts = [];
foreach ($companyStats as $company) {
    $companyInfo = oneRaw("SELECT name FROM companies WHERE id = {$company['company_id']}");
    $companyNames[] = $companyInfo['name'];
    $companyCounts[] = $company['count'];
}

// Thống kê số sinh viên được nhận theo từng nguyện vọng , trả về [['priority' => 1, 'count' => 50]]
$priorityStats = getRaw("SELECT priority, COUNT(*) as count FROM registration WHERE status = 'Đã duyệt' GROUP BY priority"); 

$priorities = [];
$priorityCounts = [];
foreach ($priorityStats as $stat) {
    $priorities[] = "Nguyện vọng " . $stat['priority'];
    $priorityCounts[] = $stat['count'];
}
?>

<div id="statistic" class="section container my-4" style="display: none;">
    <h5 class="text-danger mb-4"><i class="fa fa-chart-bar"></i> Thống Kê Sinh Viên</h5>

    <!-- Row chứa 2 biểu đồ đầu -->
    <div class="row mb-4">
        <!-- Biểu đồ số sinh viên đã đăng ký và chưa đăng ký -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="text-center text-success">Số Sinh Viên Đăng Ký</h6>
                <canvas id="registrationChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        <!-- Biểu đồ số sinh viên theo giới tính -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="text-center text-info">Số Sinh Viên Theo Giới Tính</h6>
                <canvas id="genderChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ số sinh viên chọn mỗi công ty -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm p-3">
                <h6 class="text-center text-warning">Số Sinh Viên Chọn Mỗi Công Ty</h6>
                <canvas id="companyChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ số sinh viên theo nguyện vọng -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm p-3">
                <h6 class="text-center text-danger">Tỷ Lệ Sinh Viên Được Nhận Theo Nguyện Vọng</h6>
                <canvas id="priorityChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ số sinh viên đã đăng ký và chưa đăng ký
    //Lấy đối tượng <canvas> có id là registrationChart
    var ctx1 = document.getElementById('registrationChart').getContext('2d');
    var registrationChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Đã đăng ký', 'Chưa đăng ký'],
            datasets: [{
                label: 'Số sinh viên',
                data: [<?php echo $totalRegistered; ?>, <?php echo $totalNotRegistered; ?>],
                backgroundColor: ['#4CAF50', '#F44336'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        }
    });

    // Biểu đồ số sinh viên theo giới tính
    var ctx2 = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Nam', 'Nữ'],
            datasets: [{
                label: 'Số sinh viên',
                data: [<?php echo $totalMale; ?>, <?php echo $totalFemale; ?>],
                backgroundColor: ['#2196F3', '#FF9800'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        }
    });

    // Biểu đồ số sinh viên chọn mỗi công ty
    var ctx3 = document.getElementById('companyChart').getContext('2d');
    var companyChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($companyNames); ?>,
            datasets: [{
                label: 'Số sinh viên',
                data: <?php echo json_encode($companyCounts); ?>,
                backgroundColor: '#FFC107',
                borderColor: '#fff',
                borderWidth: 1
            }]
        }
    });

    // Biểu đồ số sinh viên được nhận theo nguyện vọng
    var ctx4 = document.getElementById('priorityChart').getContext('2d');
    var priorityChart = new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($priorities); ?>,
            datasets: [{
                label: 'Số sinh viên',
                data: <?php echo json_encode($priorityCounts); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                borderColor: ['#fff', '#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>