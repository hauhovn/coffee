<?php
// Gọi file connection.php
require "connection.php";

// Thiết lập tiêu đề cho API
header("Content-Type: application/json");

// Kiểm tra phương thức HTTP
$method = $_SERVER["REQUEST_METHOD"];

// Xử lý yêu cầu GET - Lấy tất cả các nguyên liệu
if ($method === "GET") {
    try {
        // Chuẩn bị câu truy vấn SQL để lấy tất cả các nguyên liệu
        $sql = "SELECT * FROM ingredients";
        
        // Thực thi câu truy vấn SQL
        $stmt = $conn->query($sql);
        
        // Lấy tất cả các bản ghi từ kết quả truy vấn
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($ingredients);
    } catch(PDOException $e) {
        // Trả về thông báo lỗi nếu có lỗi xảy ra
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Xử lý yêu cầu POST - Tạo mới nguyên liệu
elseif ($method === "POST") {
    // Đọc dữ liệu từ body của yêu cầu
    $data = json_decode(file_get_contents("php://input"), true);
    // Lấy dữ liệu từ body
    $name = $data['name'];
    $price = $data['price'];
    $quantity = $data['quantity'];
    $unit = $data['unit'];
    
    try {
        // Chuẩn bị câu truy vấn SQL để chèn nguyên liệu mới vào cơ sở dữ liệu
        $sql = "INSERT INTO ingredients (name, price, quantity, unit) VALUES (:name, :price, :quantity, :unit)";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit', $unit);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Trả về thông báo thành công
        echo json_encode(["message" => "Ingredient created successfully"]);
    } catch(PDOException $e) {
        // Trả về thông báo lỗi nếu có lỗi xảy ra
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Xử lý các phương thức HTTP khác
else {
    // Trả về thông báo lỗi nếu phương thức không được hỗ trợ
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
}
?>
