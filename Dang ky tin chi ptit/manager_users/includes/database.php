<?php

if (!defined('_CODE')) {
    die('Access denied');
}

function query($sql, $data = [],$check = false) {
    global $conn;
    $ketqua = false; 
    try {
        $statement = $conn->prepare($sql);

        if (!empty($data)) {
            $ketqua = $statement ->execute($data);
        }
        else {
            $ketqua = $statement->execute();
        }

    } catch (Exception $exp) {
        // Xử lý lỗi
        echo $exp->getMessage().'<br>';
        echo 'File: '. $exp->getFile().'<br>';
        echo 'Line: '. $exp->getLine();
        die();
    }
    if ($check){
        return $statement;
    }
    return $ketqua;

}

//Hàm insert vào data
// $data = [
//     'username' => 'john',
//     'password' => password_hash('12345', PASSWORD_DEFAULT)
// ];
// insert('users', $data);
function insert($table, $data) {
    //['username', 'password']
    $key = array_keys($data); 

    //'username,password'
    $truong = implode(',', $key); 

    //':username,:password'
    $valuetb = ':'.implode(',:', $key); 

    //INSERT INTO users (username, password) VALUES (:username, :password)
    $sql = 'INSERT INTO '. $table .'('. $truong .')'.'VALUES('. $valuetb .')'; 

    $kq = query($sql, $data);
    return $kq;
}


//Hàm update data
// // $data = [
//     'username' => 'john',
//     'password' => password_hash('12345', PASSWORD_DEFAULT)
// ];
// update('table_name', $data);
function update($table, $data, $condition = '') {
    $update = [];
    $params = [];
    foreach ($data as $key => $value) {
         // 'username = :username', 'password = :password'
        $update[] = "$key = :$key"; 
        //':username' => 'john', ':password' => '12345'
        $params[":$key"] = $value; 
    }

    // "username = :username, password = :password"
    $updateStr = implode(', ', $update); // Ghép các trường thành chuỗi

    if (!empty($condition)) {
        // UPDATE table_name SET username = :username, password = :password WHERE condition
        $sql = "UPDATE $table SET $updateStr WHERE $condition";
    } else {
        // UPDATE table_name SET username = :username, password = :password
        $sql = "UPDATE $table SET $updateStr";
    }

    return query($sql, $params); // Gọi hàm query với SQL và các tham số
}


//Hàm delete
function delete($table, $condition='') {
    if (empty($condition)) {
        $sql = 'DELETE FROM '. $table;
    } else {
        $sql = 'DELETE FROM '. $table.' WHERE '. $condition;
    }
    $kq = query($sql);
    return $kq;
}

//Lấy nhiều dòng dữ liệu
function getRaw($sql) {
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq->fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}
//Lấy 1 dòng dữ liệu
function oneRaw($sql) {
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq->fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

//Đếm số dòng dữ liệu
function getRows($sql){
    $kq = query($sql, '', true);
    if (!empty($kq)) {
        $dataFetch = $kq->rowCount();
    }
    return $dataFetch;
}