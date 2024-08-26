<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Encryption/Decryption</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d057d786c7.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="AES" style="display: flex; justify-content: center; align-items: center; height: 90vh;">
    <div style="display: flex ;height: fit-content; border: 1px solid black;padding: 30px; border-radius: 5px;">
            <div style="border-right: 1px solid black; padding-right: 20px;">
                <h1>AES Encryption</h1>
                <div class="flex">
                        <label for="textarea">Enter text to be Encrypted</label>
                        <textarea id="plainText" name="plainText" class="textarea"></textarea>
                        <input id="secretKey" name="secretKey" style="margin-top: 20px;" placeholder="Enter secret key" type="text">
                </div>
                    <div style="padding-top: 20px; text-align: center;">
                        <button onclick="encrypted()" class="styleButton" >Encryption</button>
                    </div>
                    <div class="flex" style="margin-top: 20px; position: relative">
                        <input style="padding-right: 30px" id="encryptedText" placeholder="Encryption" "
                               disabled  type="text">
                        <div onclick="copyEncryptedText() " style="position: absolute;cursor: pointer; top: 50%; right: 10px; transform: translateY(-50%)">
                            <i class="fa-solid fa-copy"></i>
                        </div>
                </div>
            </div>
        <div style="padding-left: 20px;">
            <h1>AES Decryption</h1>
                <div class="flex">
                    <label for="textarea">Enter text to be Decrypted</label>
                    <textarea id="decryptedPlainText" name="decryptedPlainText" class="textarea" ></textarea>
                    <input id="secretKeyDecryptedText" name="secretKeyDecryptedText" style="margin-top: 20px;" placeholder="Enter secret key" type="text">
                </div>
                <div style="padding-top: 20px; text-align: center;">
                    <button onclick="decrypted()" class="styleButton">Decryption</button>
                </div>
            <div class="flex" style="margin-top: 20px;">
                <input id="decrypted_Text" placeholder="Decryption" disabled  type="text">
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript">

</script>
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
            var plainText = document.getElementById("plainText").value
            var secretKey = document.getElementById("secretKey").value
            $.ajax({
                type: "POST",
                url: "AES_Encrypt.php",
                data: { plainText: plainText, secretKey: secretKey },
                success: function(response){
                    document.getElementById("encryptedText").value = response
                }
            });
        }
        function decrypted () {
            var decryptedPlainText = document.getElementById("decryptedPlainText").value
            var secretKeyDecryptedText = document.getElementById("secretKeyDecryptedText").value
            $.ajax({
                type: "POST",
                url: "AES_Decrypt.php",
                data: { decryptedPlainText: decryptedPlainText, secretKeyDecryptedText: secretKeyDecryptedText },
                success: function(response){
                    document.getElementById("decrypted_Text").value = response
                }
            });
        }
</script>

</html>


