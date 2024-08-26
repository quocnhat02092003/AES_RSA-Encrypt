<?php
$plainText = "";
$encrypted_Text = "";
$secretKey = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Kiểm tra xem phương thức yêu cầu HTTP có phải là POST không.
    // Nếu là, mã trong khối này sẽ được thực thi.
    // Điều này là cách thông thường để kiểm tra xem một biểu mẫu đã được gửi đi qua POST hay không.
    if (isset($_POST['plainText']) && isset($_POST['secretKey'])) {//Kiểm tra xem các trường biểu mẫu có tên plainText
        // và secretKey đã được thiết lập trong yêu cầu POST hay không.
        // isset() là một hàm trong PHP kiểm tra xem một biến có được thiết lập và không phải là NULL hay không.
        $plainText = $_POST['plainText']; //Gán giá trị gửi đi qua post vào các biến
        $secretKey = $_POST['secretKey'];
        if ($plainText != "" && $secretKey != "") { //Check nếu các biến có giá trị
            $iv = openssl_random_pseudo_bytes(16);//Tạo các byte ngẫu nhiên có độ dài 16 byte
            $encrypted = openssl_encrypt($plainText, 'aes-256-cbc', $secretKey, 0, $iv);//Mã
            // hóa $plainText bằng thuật toán mã hóa AES trong chế độ CBC (Cipher Block Chaining) với
            // kích thước khóa 256 bit. Nó sử dụng $secretKey làm khóa mã hóa và $iv làm các byte khởi tạo.
            echo $encrypted_Text = base64_encode($encrypted . '::' . $iv);//Dòng này nối chuỗi văn bản
            // đã được mã hóa và IV được phân tách bằng ::, sau đó mã hóa chuỗi kết hợp bằng base64, và
            // cuối cùng, nó in kết quả. Thường thì điều này được thực hiện để đảm bảo rằng
            // văn bản đã được mã hóa và IV được truyền đi an toàn qua các hệ thống khác nhau,
            // vì mã hóa base64 đảm bảo rằng dữ liệu chỉ chứa các ký tự ASCII có thể in được.
        } else { //Nếu các biến có giá trị rỗng
            echo $encrypted_Text = ""; //In ra kết quả mã hóa là rỗng
        }
    }
}
?>
