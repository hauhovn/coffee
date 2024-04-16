<?php
// Gọi file connection.php
require "connection.php";

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    try {
        // Chuẩn bị câu lệnh SQL để cập nhật thông tin người dùng
        $sql = "UPDATE users SET name = :name, password = :password WHERE id = :id";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Hiển thị thông báo nếu cập nhật thành công
        echo "User updated successfully";
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
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id">ID:</label><br>
        <input type="text" id="id" name="id" required><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
