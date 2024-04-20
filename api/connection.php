<?php

require __DIR__."/config.php";

$dsn = 'mysql:dbname='.$config["database"]["database"].';host='.$config["database"]["hostname"];
$user = $config["database"]["username"];
$password = $config["database"]["password"];

try {
    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new PDO($dsn, $user, $password);
    // Thiết lập chế độ lỗi cho PDO để hiển thị thông báo lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch(PDOException $e) {
    // Nếu không thể kết nối, hiển thị thông báo lỗi
    echo "Connection failed: " . $e->getMessage();
}
?>
