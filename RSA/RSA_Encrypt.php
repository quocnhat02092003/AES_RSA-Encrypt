<?php
$plaintextRSA = "";
$secretKeyEncrypt = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Kiểm tra xem phương thức yêu cầu HTTP có phải là POST không.
    // Nếu là, mã trong khối này sẽ được thực thi.
    // Điều này là cách thông thường để kiểm tra xem một biểu mẫu đã được gửi đi qua POST hay không.
    if (isset($_POST['plaintextRSA']) && isset($_POST['secretKeyEncrypt'])){//Kiểm tra xem các trường biểu mẫu có tên plaintextRSA
        // và secretKeyEncrypt đã được thiết lập trong yêu cầu POST hay không.
        // isset() là một hàm trong PHP kiểm tra xem một biến có được thiết lập và không phải là NULL hay không.
        $plaintextRSA = $_POST['plaintextRSA']; //Gán giá trị gửi đi qua post vào các biến
        $secretKeyEncrypt = $_POST['secretKeyEncrypt'];
    }
}
function rsaEncrypt($plaintext, $publicKey) {
    if ($plaintext != "" && $publicKey != ""){//Check xem plaintext và publicKey có rỗng không

        // Giải mã khóa công khai từ base64
        $publicKey = base64_decode($publicKey);

        // Lấy khóa công khai
        $rsaKey = openssl_pkey_get_public($publicKey);
        //openssl_pkey_get_public(): Đây là một hàm trong PHP OpenSSL Extension được sử dụng để lấy một biểu diễn cho một
        // khóa công khai từ một chuỗi biểu diễn của nó. Trong trường hợp này, nó nhận một chuỗi biểu diễn của khóa công khai (đã được mã
        // hóa base64) và trả về một biểu diễn cho khóa công khai đó.
        //$publicKey: Đây là chuỗi biểu diễn của khóa công khai, đã được mã hóa base64 và truyền vào hàm openssl_pkey_get_public().
        //$rsaKey: Đây là biến mà biểu diễn của khóa công khai sẽ được gán vào sau khi hàm openssl_pkey_get_public() được gọi. Điều này cho phép bạn sử dụng
        //biểu diễn của khóa công khai trong các hoạt động mã hóa hoặc xác thực khác

        // Mã hóa văn bản sử dụng khóa công khai
        openssl_public_encrypt($plaintext, $encrypted, $rsaKey);//openssl_public_encrypt(): Đây là một hàm trong PHP OpenSSL Extension được
        // sử dụng để mã hóa dữ liệu sử dụng khóa công khai RSA.
        //$plaintext: Đây là dữ liệu văn bản cần mã hóa.
        //$encrypted: Đây là biến mà kết quả sau khi mã hóa sẽ được gán vào.
        //$rsaKey: Đây là biểu diễn của khóa công khai RSA được sử dụng để mã hóa dữ liệu. Trước đó, bạn đã lấy biểu diễn này từ chuỗi biểu
        // diễn của khóa công khai và gán vào biến

        // Trả về văn bản đã được mã hóa
        return base64_encode($encrypted);
    }
}
echo $encrypted_Text = rsaEncrypt($plaintextRSA, $secretKeyEncrypt);

?>