<?php
// Gọi file connection.php
require "connection.php";

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    try {
        // Tạo câu lệnh SQL để chèn dữ liệu vào bảng customers
        $sql = "INSERT INTO customers (name, phone, password, created_at) VALUES (:name, :phone, :password, NOW())";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Hiển thị thông báo nếu thêm khách hàng thành công
        echo "Customer created successfully";
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
    <title>Create Customer</title>
</head>
<body>
    <h2>Create Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Create">
    </form>
</body>
</html>
