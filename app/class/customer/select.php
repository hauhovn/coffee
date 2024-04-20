<?php
// Gọi file connection.php
require "connection.php";

try {
    // Chuẩn bị câu truy vấn SQL để lấy thông tin khách hàng
    $sql = "SELECT * FROM customers";
    
    // Thực thi câu truy vấn SQL
    $stmt = $conn->query($sql);
    
    // Lấy tất cả các bản ghi từ kết quả truy vấn
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Hiển thị thông tin khách hàng
    echo "<h2>Danh sách khách hàng</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Phone</th><th>Created At</th></tr>";
    foreach ($customers as $customer) {
        echo "<tr>";
        echo "<td>".$customer['id']."</td>";
        echo "<td>".$customer['name']."</td>";
        echo "<td>".$customer['phone']."</td>";
        echo "<td>".$customer['created_at']."</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
    // Hiển thị thông báo lỗi nếu có lỗi xảy ra
    echo "Error: " . $e->getMessage();
}
?>
