<?php
// 1. 連接資料庫 (請確認你的資料庫名稱是否為 project_db)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}

// 2. 接收來自 HTML 表單的資料 (對應 HTML 的 name 屬性)
// 使用 isset() 檢查必填項目，防止未填寫直接操作造成的錯誤
$booking_date = isset($_POST['text1']) ? $_POST['text1'] : '';
$user_name = isset($_POST['text2']) ? $_POST['text2'] : '';
$monument = isset($_POST['monument']) ? $_POST['monument'] : '';

// 檢查欄位是否為空
if (empty($booking_date) || empty($user_name) || empty($monument)) {
    echo "<script>alert('所有欄位皆為必填！'); history.back();</script>";
    exit;
}

// 3. 撰寫 SQL 插入語法 (將變數帶入剛剛建立的欄位)
$sql = "INSERT INTO registrations (booking_date, user_name, monument) 
        VALUES ('$booking_date', '$user_name', '$monument')";

// 4. 執行並判斷是否成功
if ($conn->query($sql) === TRUE) {
    // 成功後跳出提示視窗，並導回表單頁面 (假設你的表單檔名叫 form.html)
    echo "<script>alert('八卦山巡禮活動報名成功！'); location.href='form.html';</script>";
} else {
    echo "報名失敗，錯誤訊息: " . $conn->error;
}

// 關閉資料庫連線
$conn->close();
?>
