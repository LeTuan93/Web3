<?php

if (!defined('_CODE')) {
    die('Access denied');
}
?>
<!-- <!DOCTYPE html> -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['pageTitle']) ? $data['pageTitle']:'Đăng ký thực tập PTIT' ?></title>
    <link rel="stylesheet" href= "<?php echo _WEB_HOST_TEMPLATES; ?> /css/bootstrap.min.css">
    <link rel="stylesheet" href= "<?php echo _WEB_HOST_TEMPLATES; ?> /css/style.css?ver=<?php echo rand(); ?>">
    <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"> -->
</head>
<body>
    
</body>
</html>


<header class="text-white py-2 rounded-top" style="background-color: #ad171c !important; border-color: #901317 !important;">
    <div class="container-fluid d-flex align-items-center justify-content-start" style="height: 50px;">
        <div class="d-flex align-items-center me-4">
            <i class="fas fa-home fa-lg me-2"></i>
            <h4 class="mb-0 ms-0">Trang chủ</h4>
        </div>
        <div class="d-flex align-items-center">
            <i class="fas fa-user fa-lg me-2"></i>
            <h4 class="mb-0 ms-0">Thông tin</h4>
        </div>
    </div>
</header>

