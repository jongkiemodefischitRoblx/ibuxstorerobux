<?php
require 'config.php';
require 'vendor/autoload.php'; // PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

// Ambil data dari form
$produk = $_POST['produk'] ?? '';
$paket = $_POST['paket'] ?? '';
$harga = $_POST['harga'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';

// Generate ID transaksi
$id = rand(100000,999999);

// ======== STOK OTOMATIS ========
if(file_exists('stock.json')){
    $stockData = json_decode(file_get_contents('stock.json'), true);
    if(isset($stockData[$produk])){
        if($stockData[$produk] > 0){
            $stockData[$produk] -= 1;
            file_put_contents('stock.json', json_encode($stockData));
        } else {
            echo "<script>alert('Maaf, stok produk sudah habis!'); window.history.back();</script>";
            exit;
        }
    }
}

// ======== LINK WA OTOMATIS ========
$linkWa = "https://wa.me/".str_replace('+','',$ADMIN_WA)."?text=".urlencode("
Halo Kak 👋
Mohon Di Proses Secepatnya Ya
Detail Pembelian:
Produk / Paket: $produk $paket
Harga: $harga
Username / Email: $username
ID Transaksi: $id
");

// ======== KIRIM EMAIL ========
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $EMAIL_USER;
    $mail->Password = $EMAIL_PASS;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom($EMAIL_USER,$STORE_NAME);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Order $produk | $STORE_NAME";
    $mail->Body = "
    <b>Terima kasih sudah order di $STORE_NAME!</b><br><br>
    Produk / Paket: $produk $paket<br>
    Harga: $harga<br>
    Username / Email: $username<br>
    ID Transaksi: $id<br><br>
    Klik tombol di bawah untuk hubungi Admin:
    <a style='padding:12px 18px;background:#1da1f2;color:white;border-radius:8px;text-decoration:none;font-weight:bold' href='$linkWa'>Hubungi Admin via WhatsApp</a>
    ";

    $mail->send();
    echo "<script>alert('Order berhasil! Silahkan cek email.');window.location.href='success.html';</script>";
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>
