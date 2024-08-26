<?php
$cipherText= "";
$secretKeyDecrypt = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Kiểm tra xem phương thức yêu cầu HTTP có phải là POST không.
    // Nếu là, mã trong khối này sẽ được thực thi.
    // Điều này là cách thông thường để kiểm tra xem một biểu mẫu đã được gửi đi qua POST hay không.
    if (isset($_POST['cipherText']) && isset($_POST['secretKeyDecrypt'])){//Kiểm tra xem các trường biểu mẫu có tên cipherText
        // và secretKeyDecrypt đã được thiết lập trong yêu cầu POST hay không.
        // isset() là một hàm trong PHP kiểm tra xem một biến có được thiết lập và không phải là NULL hay không.
        $cipherText = $_POST['cipherText'];////Gán giá trị gửi đi qua post vào các biến
        $secretKeyDecrypt = $_POST['secretKeyDecrypt'];
    }
}
function rsaDecrypt($ciphertext, $privateKey) {
    if ($ciphertext != "" && $privateKey != "") {//Check các giá trị ciphertext và private key nếu không rỗng
        // Giải mã khóa bí mật từ base64
        $privateKey = base64_decode($privateKey);

        // Lấy khóa bí mật
        $rsaKey = openssl_pkey_get_private($privateKey);
        //Dòng mã này sử dụng hàm openssl_pkey_get_private() để lấy một biểu diễn cho một khóa bí mật từ chuỗi biểu diễn của
        // nó ($privateKey). Điều này cho phép sử dụng khóa bí mật trong các hoạt động giải mã khác

        // Giải mã văn bản sử dụng khóa bí mật
        openssl_private_decrypt(base64_decode($ciphertext), $decrypted, $rsaKey);
        //Sử dụng hàm openssl_private_decrypt() để giải mã dữ liệu đã được mã hóa sử dụng khóa bí mật RSA.
        //Dữ liệu đã được mã hóa là chuỗi đã được giải mã từ base64 (base64_decode($ciphertext)).
        //Kết quả sau khi giải mã sẽ được gán vào biến $decrypted, là văn bản gốc trước khi được mã hóa.

        // Trả về văn bản đã được giải mã
        return $decrypted;
    }
}

echo $decrypted_Text = rsaDecrypt($cipherText, $secretKeyDecrypt);
?>