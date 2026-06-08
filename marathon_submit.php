<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// 接收表單資料
$challenge_date = isset($_POST['date']) ? trim($_POST['date']) : '';
$runner_name = isset($_POST['name']) ? trim($_POST['name']) : '';
$challenge_type = isset($_POST['type']) ? $_POST['type'] : 'run';

// 接收隱藏的 GPS 資料 (如果使用者沒點定位，就存 NULL)
$latitude = !empty($_POST['lat']) ? trim($_POST['lat']) : '未定位';
$longitude = !empty($_POST['lng']) ? trim($_POST['lng']) : '未定位';

// 基礎欄位驗證
if (empty($challenge_date) || empty($runner_name)) {
    echo "<script>alert('日期與姓名為必填欄位！'); history.back();</script>";
    exit;
}

// 安全過濾
$date_clean = $conn->real_escape_string($challenge_date);
$name_clean = $conn->real_escape_string($runner_name);
$type_clean = $conn->real_escape_string($challenge_type);
$lat_clean = $conn->real_escape_string($latitude);
$lng_clean = $conn->real_escape_string($longitude);

// 寫入資料庫
$sql = "INSERT INTO form_run (challenge_date, runner_name, challenge_type, latitude, longitude) 
        VALUES ('$date_clean', '$name_clean', '$type_clean', '$lat_clean', '$lng_clean')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('【彰師校區馬拉松】報名成功！\\n一起從進德跑到寶山吧！'); 
            location.href='你從進德寶山.html';
          </script>";
} else {
    echo "錯誤: " . $conn->error;
}

$conn->close();
?>
