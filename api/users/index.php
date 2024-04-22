<?php
// Gọi file connection.php
require "../connection.php";

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
        // Lấy giới hạn số lượng theo ngày tạo mới nhất
            $sql = "SELECT * FROM ".$table." ORDER BY created_at  DESC limit ".$_GET['limit']; //"limit ".($_GET['limit']). 
        }elseif(isset($_GET['id'])){
        // Lấy theo id
        $sql = "SELECT * FROM ".$table." WHERE id = ".$_GET['id']."";
        }elseif(isset($_GET['phone'])){
        // Lấy theo phone
        $sql = "SELECT * FROM ".$table." WHERE phone = ".$_GET['phone']."";
        }else{
        // Chuẩn bị câu truy vấn SQL để lấy tất cả
        $sql = "SELECT * FROM ".$table." $limit";
        }
        
        // Thực thi câu truy vấn SQL
        $stmt = $conn->query($sql);
        
        // Lấy tất cả các bản ghi từ kết quả truy vấn
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($ingredients);
    } catch(PDOException $e) {
        // Trả về thông báo lỗi nếu có lỗi xảy ra
        echo json_encode(["error" => $e->getMessage()]);
        echo json_encode(["sql" => $sql]);
    }
}

// Xử lý yêu cầu POST - Tạo mới nguyên liệu
elseif ($method === "POST") {
   // Đọc dữ liệu từ body của yêu cầu
   $data = json_decode(file_get_contents("php://input"), true);

     // Lấy dữ liệu từ body
     $phone = $data['phone'];
     $first_name = $data['first_name'];
     $last_name = $data['last_name'];
     $password = $data['password'];

     if(!isset($phone)||!isset($first_name)||!isset($last_name)||!isset($password)){
        echo json_encode(["error" => "Không nhận đủ thông tin"]);
        // Dừng xử lý ở đây
        exit();
     }

    try {
        // =======================check account============================== //
        // SQL lấy phone có status >=0
        $select_user_sql = "SELECT phone FROM ".$table. 
        " WHERE phone = '".$phone."' AND STATUS >=0";

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
            echo json_encode(["error"=>"phone tồn tại"]);
            exit();
        } else {
        // Không có dữ liệu được trả về == mail chưa được dùng
        // Xử lý
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        // Chuẩn bị câu truy vấn SQL để chèn nguyên liệu mới vào cơ sở dữ liệu
        $sql = "INSERT INTO ".$table." (phone, first_name, last_name, password) VALUES (:phone, :first_name, :last_name,:password)";
        
        // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind các giá trị vào các tham số của câu lệnh SQL
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':password', $hashed_password);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Trả về thông báo thành công
        echo json_encode(["message" => "Hello ".$last_name." your phone: ".$phone]);
        }
       
    } catch(PDOException $e) {
         // Trả về thông báo lỗi nếu có lỗi xảy ra
         echo json_encode(["error" => $e->getMessage()]);
    }
}
elseif($method === "PUT"){
    // Đọc dữ liệu từ body của yêu cầu
    $data = json_decode(file_get_contents("php://input"), true);
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $new_password = $data['new_password'];
    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
    // Check theo phone hay id
    if(isset($data['id'])){
        $id = $data['id'];
        $condition = " WHERE id=:id";
    }elseif(isset($data['phone'])){
        $phone = $data['phone'];
        $condition = " WHERE phone=:phone";
    }else{
    // Không nhận được giá trị để KEY (id,phone) để cập nhật
    echo json_encode(["message" => "Không nhận được giá trị để KEY (id,phone) để cập nhật"]);
    exit();
    }
    //Querry
    $sql = "UPDATE ".$table
    ." SET first_name=:first_name, last_name=:last_name, password=:hashed_new_password "
    .$condition;
    // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
    $stmt = $conn->prepare($sql);
    // Bind các giá trị vào các tham số của câu lệnh SQL
    if(isset($id)){
    $stmt->bindParam(':id', $id);
    }
    else{
        $stmt->bindParam(':phone', $phone);
    }
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':hashed_new_password', $hashed_new_password);
    // Thực thi câu lệnh SQL
    $stmt->execute();
    // Kiểm tra số lượng hàng đã được cập nhật
    $row_count = $stmt->rowCount();
    if ($row_count > 0) {
    // Có ít nhất một hàng đã được cập nhật
    echo json_encode(["message" => "Đã cập nhật thông tin THÀNH CÔNG cho ".$last_name]);
    } else {
    // Không có hàng nào được cập nhật
    echo json_encode(["message" => "Cập nhật KHÔNG thành công ".$last_name]);
    }
    
}
// Xử lý các phương thức HTTP khác
else {
    // Trả về thông báo lỗi nếu phương thức không được hỗ trợ
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
}
?>


