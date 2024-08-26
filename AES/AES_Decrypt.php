<?php
$decryptedPlainText = "";
$secretKeyDecryptedText = "";
$decrypted_Text = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Kiểm tra xem phương thức yêu cầu HTTP có phải là POST không.
    // Nếu là, mã trong khối này sẽ được thực thi.
    // Điều này là cách thông thường để kiểm tra xem một biểu mẫu đã được gửi đi qua POST hay không.
    if (isset($_POST['decryptedPlainText']) && isset($_POST['secretKeyDecryptedText'])){//Kiểm tra xem các trường biểu mẫu có tên decryptedPlainText
        // và secretKey đã được thiết lập trong yêu cầu POST hay không.
        // isset() là một hàm trong PHP kiểm tra xem một biến có được thiết lập và không phải là NULL hay không.
        $decryptedPlainText = $_POST['decryptedPlainText'];//Gán các giá trị gửi đi qua POST vào các biến
        $secretKeyDecryptedText = $_POST['secretKeyDecryptedText'];
        if ($decryptedPlainText != "" && $secretKeyDecryptedText != "") {// Check các biến nếu không rỗng
            //Hàm list trong đoạn mã
            // trên được sử dụng để gán giá trị cho nhiều biến cùng một lúc từ một mảng hoặc một chuỗi.
            list($encrypted_data, $iv) = explode("::", base64_decode($decryptedPlainText), 2);

            //explode("::", ... , 2): Sau đó, nó tách chuỗi đã giải mã thành hai phần dựa trên dấu :: và lưu trữ kết quả vào
            // mảng $encrypted_data và $iv.

            echo $decrypted_Text = openssl_decrypt($encrypted_data, 'aes-256-cbc', $secretKeyDecryptedText, 0, $iv);
            //openssl_decrypt(): Hàm này được sử dụng để giải mã dữ liệu đã được mã hóa bằng AES. Nó nhận vào các tham số sau:
            //$encrypted_data: Dữ liệu đã được mã hóa.
            //'aes-256-cbc': Thuật toán mã hóa được sử dụng (AES với chế độ CBC).
            //$secretKeyDecryptedText: Khóa được sử dụng để giải mã dữ liệu. Đây là khóa đã được giải mã từ $secretKeyDecryptedText.
            //$iv: Vector khởi tạo đã sử dụng khi mã hóa dữ liệu
        }
        else { //Check các biến nếu rỗng
            echo $decrypted_Text = "";
        }
    }
}
?>