<?php
$rsaKeySize = 512; //Khai báo cặp key có size mặc định là 512
function generateAndEncodeRSAKeyPair($keySize) {
    // Tạo cặp khóa RSA
    $config = array( //Đoạn này khai báo một mảng $config chứa các cài đặt cho quá trình tạo khóa RSA
        "digest_alg" => "sha512",//Thuật toán băm được sử dụng để tạo chữ ký của khóa.
        "private_key_bits" => $keySize,// Kích thước của khóa riêng tư, được truyền từ tham số $keySize.
        "private_key_type" => OPENSSL_KEYTYPE_RSA,//Loại của khóa riêng tư, trong trường hợp này là RSA.
    );

    //Sinh khóa bí mật mới
    $res = openssl_pkey_new($config);//Dòng này tạo ra một cặp khóa RSA mới dựa trên các cài đặt trong mảng
    // $config và gán kết quả vào biến $res.

    // Lấy thông tin khóa
    openssl_pkey_export($res, $privateKey);//Dòng này lấy thông tin về khóa riêng tư từ biến $res và gán nó vào biến $privateKey.

    // Lấy thông tin khóa công khai
    $publicKey = openssl_pkey_get_details($res);//Dòng này lấy thông tin về khóa công khai từ biến $res và gán kết quả vào biến $publicKey.
    $publicKey = $publicKey["key"];//Dòng này lấy giá trị của khóa công khai từ mảng $publicKey và gán vào biến $publicKey.

    // Chuyển đổi khóa sang base64
    $privateKeyBase64 = base64_encode($privateKey); //Chuyển khóa riêng tư sang chuỗi base64 và gán vào biến $privateKeyBase64
    $publicKeyBase64 = base64_encode($publicKey);//Chuyển khóa công khai sang chuỗi base64 và gán vào biến $publicKeyBase64

    // Trả về cặp khóa dưới dạng mảng
    return array(
        'privateKey' => $privateKeyBase64,
        'publicKey' => $publicKeyBase64
    );

}

if (!empty($_POST) && isset($_POST["RSA_Key"])) {
    $rsaKeySize = (int)$_POST["RSA_Key"]; //Nhận tham số rsaKey là 1 string và chuyển đổi sang kiểu int
}

$keyPair = generateAndEncodeRSAKeyPair($rsaKeySize);
$private_Key = $keyPair['privateKey'];//Gán giá trị của khóa riêng tư vào 1 biến được lấy trong mảng
// sau khi hàm generateAndEncodeRSAKeyPair trả về
$public_Key = $keyPair['publicKey'];//Gán giá trị của khóa công khai vào 1 biến được lấy trong mảng
// sau khi hàm generateAndEncodeRSAKeyPair trả về

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSA Encryption/Decryption</title>
    <script src="https://kit.fontawesome.com/d057d786c7.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div style="display: flex; justify-content: center; align-items: center; height: 95vh;flex-direction: column">
    <h1>RSA Key Pairs</h1>
    <form method="post">
        <div>
            <label>
                Select RSA key sizes
            </label>
            <select name="RSA_Key">
                <option <?php if ($rsaKeySize == 512) echo "selected"; ?>  value="512">
                    512 bits
                </option>
                <option <?php if ($rsaKeySize == 1024) echo "selected"; ?> value="1024">
                    1024 bits
                </option>
                <option <?php if ($rsaKeySize == 2048) echo "selected"; ?> value="2048">
                    2048 bits
                </option>
                <option <?php if ($rsaKeySize == 3072) echo "selected"; ?> value="3072">
                    3072 bits
                </option>
                <option <?php if ($rsaKeySize == 4096) echo "selected"; ?> value="4096">
                    4096 bits
                </option>
            </select>
        </div>
        <button style="margin-top: 10px">
            Generate RSA Key Pair
        </button>
    </form>
    <div style="display: flex; gap: 50px; margin-top: 30px">
        <div style="display: flex; flex-direction:column">
            <label>Public Key Size <?=$rsaKeySize?> bits (Base64)</label>
            <textarea style="width: 40vh; height: 10vh" disabled placeholder="Public Key (Base64)"><?=$public_Key?></textarea>
        </div>
        <div style="display: flex; flex-direction:column">
            <label>Private Key Size <?=$rsaKeySize?> bits (Base64)</label>
            <textarea style="width: 40vh; height: 10vh" disabled placeholder="Private Key (Base64)"><?=$private_Key?></textarea>
        </div>
    </div>
    <div style="border: 1px solid black; padding: 20px 60px 30px 60px; margin-top: 20px; border-radius: 20px">

        <h2 style="text-align: center">RSA Encryption and Decryption</h2>
        <div style="display: flex;">
                <div class="encryption_RSA" style="display: flex; flex-direction: column; border-right: 1px solid black; padding-right: 10px">
                    <label>
                        Enter Plain Text to Encrypt
                    </label>
                    <textarea id="plainText_RSA" name="plainTextRSA" style="width: 30vh; height: 10vh" placeholder="Enter Plain Text to Encrypt"></textarea>
                    <label for="plainTextRSA">
                        Enter Public key
                    </label>
                    <textarea id="secretKeyEncrypt_RSA" name="secretKeyEncrypt" style="width: 30vh;height: 10vh" placeholder="Enter Public key to Encrypt"></textarea>
                    <button onclick="encrypted()">Encrypt</button>
                    <div style="margin-top: 20px; position: relative">
                        <textarea style=" width: fit-content;width: 30vh; height: 10vh" id="encryptedText" placeholder="Encryption" disabled></textarea>
                    </div>
                </div>
<!--            Decryption-->
            <div class="decryption_RSA" style="display: flex; flex-direction: column; padding-left: 10px">
                <label>
                    Enter Encrypted Text to Decrypt
                </label>
                <textarea id="plainTextDecrypt_RSA" style="width: 30vh; height: 10vh" placeholder="Enter Encrypted Text to Decrypt"></textarea>
                <label for="plainTextDecryptRSA">
                    Enter Private key
                </label>
                <textarea style="width: 30vh; height: 10vh" id="secretKeyDecrypt_RSA" placeholder="Enter Private key to Decrypt"></textarea>
                <button onclick="decrypted()">Decrypt</button>
                <div style="margin-top: 20px; position: relative">
                    <textarea style=" width: fit-content;width: 30vh; height: 10vh" id="decryptedText" placeholder="Decryption" disabled></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    function copyEncryptedText () {
        const encryptedText = document.getElementById("encryptedText").value
        navigator.clipboard.writeText(encryptedText)
            .then(() => {
                alert("Copied to clipboard : Encrypted Text")
            })
            .catch(err => console.error("Không thể sao chép", err))
    }

    function encrypted () {
        var plainText = document.getElementById("plainText_RSA").value
        var secretKey = document.getElementById("secretKeyEncrypt_RSA").value
        $.ajax({
            type: "POST",
            url: "RSA_Encrypt.php",
            data: { plaintextRSA: plainText, secretKeyEncrypt: secretKey },
            success: function(response){
               document.getElementById("encryptedText").value = response
            }

        });
    }

    function decrypted () {
        var cipherText = document.getElementById("plainTextDecrypt_RSA").value
        var secretKeyDecrypt = document.getElementById("secretKeyDecrypt_RSA").value
        $.ajax({
            type: "POST",
            url: "RSA_Decrypt.php",
            data: { cipherText: cipherText, secretKeyDecrypt: secretKeyDecrypt },
            success: function(response){
                document.getElementById("decryptedText").value = response
            }
        });
    }
</script>
</html>
