<?php
// Gọi file connection.php
require "../connection.php";

// Kiểm tra phương thức HTTP
$method = $_SERVER["REQUEST_METHOD"];

$table = "users";

// Xử lý yêu cầu GET - Lấy tất cả các nguyên liệu
if ($method === "POST") {
   // Đọc dữ liệu từ body của yêu cầu
   $data = json_decode(file_get_contents("php://input"), true);

     // Lấy dữ liệu từ body
     $email = $data['email'];
     $password = $data['password'];

     if(!isset($email)||!isset($password)){
        echo json_encode(["error" => "Không nhận đủ thông tin"]);
        // Dừng xử lý ở đây
        exit();
     }

     try {
        // =======================check account============================== //
          // SQL lấy password có status >=0
          $get_password_user_sql = "SELECT password FROM ".$table." WHERE email = :email AND STATUS >=0 limit 1";
          $stmt = $conn->prepare($get_password_user_sql);
          $stmt->bindParam(':email', $email);
          $stmt->execute();
        // $stmt = $conn->prepare("SELECT password FROM ".$table." WHERE email = ? AND STATUS >=0 limit 1");
        // $stmt->execute([$email])
        // Đếm số hàng trả về
        $rowCount = $stmt->rowCount();  
        if ($rowCount > 0) {
        // Lấy mật khẩu từ kết quả truy vấn
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row["password"];
      
          // So sánh mật khẩu đã lưu và mật khẩu gửi qua POST
          // // Kiểm tra mật khẩu
              if (password_verify($password, $hashed_password)) {
                  // Mật khẩu hợp lệ
                  echo json_encode(["message" => "Hello ".$email]);
                  // COOKIE
                  $arr_cookie_options = array (
                    'expires' => time() + 60*60*24*30, 
                    'path' => '/', 
                    'domain' => '.', // leading dot for compatibility or use subdomain
                    'secure' => true,     // or false
                    'httponly' => true,    // or false
                    'samesite' => 'None' // None || Lax  || Strict
                    );
                setcookie('TestCookie', 'The Cookie Value', $arr_cookie_options);    
              } else {
                  // Mật khẩu không hợp lệ
                  echo json_encode(["message" => "Password is incorrect! Pls try again!"]);
              }
          } else {
            echo json_encode(["message" => "Người dùng ".$email." không tồn tại","sql"=>$get_password_user_sql]);
          }
    }catch(PDOException $e) {
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


