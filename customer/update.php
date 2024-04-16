<?php
// Gọi file connection.php
require "connection.php";

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    
    try {
        // Chuẩn bị câu lệnh SQL để cập nhật thông tin khách hàng
        $sql = "UPDATE customers SET name = :name, phone = :phone WHERE id = :id";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Hiển thị thông báo nếu cập nhật thành công
        echo "Customer updated successfully";
    } catch(PDOException $e) {
        // Hiển thị thông báo lỗi nếu có lỗi xảy ra
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
</head>
<body>
    <h2>Update Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id">ID:</label><br>
        <input type="text" id="id" name="id" required><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
