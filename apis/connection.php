<?php

// Thông tin kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Địa chỉ máy chủ MySQL
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$database = "coffee_db"; // Tên cơ sở dữ liệu

try {
    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Thiết lập chế độ lỗi cho PDO để hiển thị thông báo lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    // Nếu không thể kết nối, hiển thị thông báo lỗi
    echo "Connection failed: " . $e->getMessage();
}
?>
