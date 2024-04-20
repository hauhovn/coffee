<?php
// Gọi file connection.php
require "connection.php";

// Thiết lập tiêu đề cho API
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Kiểm tra phương thức HTTP
$method = $_SERVER["REQUEST_METHOD"];

$table = "users";

// Xử lý yêu cầu GET - Lấy tất cả các nguyên liệu
if ($method === "GET") {
    try {
       
        if(isset($_GET['limit'])){
            $limit = "limit ".($_GET['limit']);
        }else{
            $limit = "";
        }
        // Chuẩn bị câu truy vấn SQL để lấy tất cả các nguyên liệu
        $sql = "SELECT * FROM ".$table." $limit";
        
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
     $email = $data['email'];
     $first_name = $data['first_name'];
     $last_name = $data['last_name'];
     $password = $data['password'];

     if(!isset($email)||!isset($first_name)||!isset($last_name)||!isset($password)){
        echo json_encode(["error" => "Không nhận đủ thông tin"]);
        // Dừng xử lý ở đây
        exit();
     }

    try {
        // =======================check account============================== //
        // SQL lấy email có status >=0
        $select_user_sql = "SELECT email FROM ".$table. 
        " WHERE email = '".$email."' AND STATUS >=0";

        // Thực thi câu truy vấn SQL
        // Chuẩn bị truy vấn SQL
        $query = "SELECT * FROM your_table";
        $user_all = $conn->prepare($select_user_sql);
        // Thực thi câu lệnh SQL
        $user_all->execute();
       // Lấy kết quả
        $result_user_all = $user_all->fetchAll(PDO::FETCH_ASSOC);
        // Kiểm tra xem có dữ liệu được trả về không
        if (count($result_user_all) > 0) {
            // Dữ liệu được trả về
            // foreach ($result_user_all as $row) {
            //     // Xử lý từng dòng dữ liệu ở đây
            //     var_dump($row);     
            // }
            echo json_encode(["error"=>"Email tồn tại"]);
            exit();
        } else {
        // Không có dữ liệu được trả về == mail chưa được dùng

        // Xử lý
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        // Chuẩn bị câu truy vấn SQL để chèn nguyên liệu mới vào cơ sở dữ liệu
        $sql = "INSERT INTO ".$table." (email, first_name, last_name, password) VALUES (:email, :first_name, :last_name,:password)";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':password', $hashed_password);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Trả về thông báo thành công
        echo json_encode(["message" => "Ingredient created successfully"]);

        }
       
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

// $hashed_password_from_database = "hashed_password_retrieved_from_database";

// // Kiểm tra mật khẩu
// if (password_verify($password_from_user_input, $hashed_password_from_database)) {
//     // Mật khẩu hợp lệ
//     echo "Password is correct";
// } else {
//     // Mật khẩu không hợp lệ
//     echo "Password is incorrect";
// }
?>


