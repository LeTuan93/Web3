<?php

if (!defined('_CODE')) {
    die('Access denied');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layouts($layoutName = 'header', $data = []) {
    if (file_exists(_WEB_PATH_TEMPLATES . "/layout/$layoutName.php")) {
        require_once _WEB_PATH_TEMPLATES . "/layout/$layoutName.php";
    } 
}

//Hàm gửi mail
function sendMail($to,$subject,$content) {    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'latuan9303@gmail.com';                     //SMTP username
        $mail->Password   = 'lmfpovcmslhkqsqd';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('latuan9303@gmail.com', 'Lê Anh Tuấn');
        $mail->addAddress($to);     //Add a recipient
        
        //Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        
        //PHPMailer SSL certificate verify failed
        $mail->SMTPOptions = array (
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $sendMail = $mail->send();
        if (!$sendMail) {
            return $sendMail;
        }
    } catch (Exception $e) {
        echo "Gửi mail thất bại. Mailer Error: {$mail->ErrorInfo}";
    }
}

//Kiểm tra phương thức GET
function isGet(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

//Kiểm tra phương thức POST
function isPost(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}


// hÀM Filter lọc dữ liệu
function filter() {
    $filterArr = [];  // Ensure this is correctly initialized.

    // Check for GET method request
    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key); //Loại bỏ bất kỳ thẻ HTML nào khỏi tên trường (key) trong dữ liệu $_GET => tránh lỗi XSS
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }   else{
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);                
                }
            }
        }
    }

    // Check for POST method request
    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }

    return $filterArr; 
}


//Kiểm tra email
function isEmail($email) {
    $checkmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkmail;
}

//Kiểm tra số nguyên INT
function isNumberInt($number) {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}
//Hàm kiểm tra số thực
function isNumberFloat($number) {
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

//hàm kiểm tra số điện thoại
function isPhone($phone) {
    $checkZero = false;
    // Điều kiện 1 : ký tự đầu là số 0
    if($phone[0] == '0') {
        $checkZero = true;
        $phone = substr($phone,1);
    }
    // Điều kiện 2 : Đằng sau nó có 9 số
    $checkNumber = false;
    if(isNumberInt($phone) && strlen($phone) == 9) {
        return true;
    }
    return false;
}
//Thông báo lỗi
function getSmg($smg,$type = 'success') {
    echo '<div class="alert alert-'.$type.'">';
    echo $smg;
    echo '</div>';
}

function redirect($path='index.php'){
    // Gửi một tiêu đề HTTP đến trình duyệt
    header("Location: $path");
    exit;
}

//Hàm thông báo lỗi  
function form_error($filename, $beforeHtml = '', $afterHtml = '', $error) 
{
    return (!empty($error[$filename])) ? '<span class="error">' .reset($error[$filename]). '</span>' : null; // reset() trả về phần tử đầu tiên trong mảng
}

//Hàm hiển thị thông tin đã điền trước đó
function old($fileName,$oldData, $dedault= null)
{
    return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $dedault;
}

//Hàm kiểm tra trạng thái đăng nhập
function isLogin() {
    $checkLogin = false;
    if (getSession('logintoken')){
        $tokenLogin = getSession( 'logintoken');
        // Kiem tra token co giong trong database
        $queryToken = oneRaw("SELECT user_id FROM logintoken WHERE token = '$tokenLogin' ");
     
        if(!empty ($queryToken )) {
            $checkLogin = true;
        }else {
            removeSession( 'logintoken') ;
        }
    }
    return $checkLogin;
}

//Hàm chuyển đổi điểm theo quy tắc 
// gpa_4 = 4 nếu gpa_10 >= 9.0 => gpa_c = A+
// gpa_4 =3.7 nếu gpa_10 >= 8.5 => gpa_c = A
// gpa_4 = 3.5 nếu gpa_10 >= 8.0 => gpa_c = B+
// gpa_4 = 3 nếu gpa_10 >= 7.0 => gpa_c = B
// gpa_4 = 2.5 nếu gpa_10 >= 6.5 => gpa_c = C+
// gpa_4 = 2 nếu gpa_10 >= 5.5 => gpa_c = C
// gpa_4 = 1.5 nếu gpa_10 >= 5.0 => gpa_c = D+  
// gpa_4 = 1 nếu gpa_10 >= 4.0 => gpa_c = D
// gpa_4 = 0 nếu gpa_10 < 4.0 => gpa_c = F
function convertGpa10($gpa_10) {
    $gpa_4 = 0;
    $gpa_c = '';
    if ($gpa_10 >= 9.0) {
        $gpa_4 = 4;
        $gpa_c = 'A+';
    } elseif ($gpa_10 >= 8.5) {
        $gpa_4 = 3.7;
        $gpa_c = 'A';
    } elseif ($gpa_10 >= 8.0) {
        $gpa_4 = 3.5;
        $gpa_c = 'B+';
    } elseif ($gpa_10 >= 7.0) {
        $gpa_4 = 3;
        $gpa_c = 'B';
    } elseif ($gpa_10 >= 6.5) {
        $gpa_4 = 2.5;
        $gpa_c = 'C+';
    } elseif ($gpa_10 >= 5.5) {
        $gpa_4 = 2;
        $gpa_c = 'C';
    } elseif ($gpa_10 >= 5.0) {
        $gpa_4 = 1.5;
        $gpa_c = 'D+';
    } elseif ($gpa_10 >= 4.0) {
        $gpa_4 = 1;
        $gpa_c = 'D';
    } else {
        $gpa_4 = 0;
        $gpa_c = 'F';
    }
    return [
        'gpa_4' => $gpa_4,
        'gpa_c' => $gpa_c
    ];
}