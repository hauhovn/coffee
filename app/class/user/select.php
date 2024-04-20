<?php
// Gọi file connection.php
require "connection.php";

try {
    // Chuẩn bị câu truy vấn SQL
    $sql = "SELECT * FROM users";
    
    // Thực thi câu truy vấn SQL
    $stmt = $conn->query($sql);
    
    // Lấy tất cả các bản ghi từ kết quả truy vấn
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Hiển thị thông tin người dùng
    echo "<h2>Danh sách người dùng</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Password</th><th>Created At</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>".$user['id']."</td>";
        echo "<td>".$user['name']."</td>";
        echo "<td>".$user['password']."</td>";
        echo "<td>".$user['created_at']."</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
    // Hiển thị thông báo lỗi nếu có lỗi xảy ra
    echo "Error: " . $e->getMessage();
}
?>
