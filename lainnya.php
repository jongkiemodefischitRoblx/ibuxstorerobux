<?php
require 'config.php';
$stockData = json_decode(file_get_contents('stock.json'), true);
$stok = $stockData['ElRetro Gran Maja'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>IbuxStore Official - Lainnya</title>
<style>
body { background:#020b22; font-family:Poppins,sans-serif; color:#00e5ff; margin:0; padding:0; }
header { padding:15px; text-align:center; border-bottom:2px solid #00e5ff; font-size:24px; font-weight:bold; }
nav { text-align:center; margin-bottom:20px; }
nav a { color:#00e5ff; margin:0 10px; text-decoration:none; font-weight:bold; }
nav a:hover { color:#0088ff; }
.container { width:95%; max-width:430px; margin:auto; }
.product-card { background:rgba(0,10,30,0.85); border:2px solid #00e5ff; border-radius:10px; padding:15px; text-align:center; margin-bottom:20px; box-shadow:0 0 20px #00e5ff; }
.product-img { width:100%; max-width:250px; border-radius:8px; margin-bottom:10px; }
.order-btn { background:#00e5ff; color:#000; padding:10px 20px; border:none; border-radius:6px; font-weight:bold; cursor:pointer; transition:.3s; }
.order-btn:hover { background:#0088ff; color:#fff; }
.order-btn:disabled { background:#555; cursor:not-allowed; color:#aaa; }
</style>
</head>
<body>
<header>IbuxStore Official</header>
<nav>
<a href="index.html">Top Up Robux</a> | <a href="lainnya.php">Lainnya</a>
</nav>
<div class="container">
  <div class="product-card">
    <img src="https://files.catbox.moe/91fcik.jpg" alt="ElRetro Gran Maja" class="product-img">
    <h3>ElRetro Gran Maja</h3>
    <p>Type Game: Fish It 🐟</p>
    <p>Harga: Rp 35.000</p>
    <p>Stock: <?php echo $stok; ?></p>
    <form action="backend.php" method="POST">
      <input type="hidden" name="produk" value="ElRetro Gran Maja">
      <input type="hidden" name="harga" value="35000">
      <label>Email:</label>
      <input type="email" name="email" required>
      <label>Username / Email Roblox:</label>
      <input type="text" name="username" required>
      <label>Pilih Metode Pembayaran:</label>
      <select name="pembayaran" required>
        <option value="">-- Pilih Metode --</option>
        <option>DANA</option>
        <option>Gopay</option>
        <option>OVO</option>
        <option>ShopeePay</option>
        <option>QRIS</option>
      </select>
      <div class="privacy">
        <input type="checkbox" id="cekbox"> Saya setuju dengan <a href="privacy.html">Privacy & Policy</a>
      </div>
      <button type="submit" class="order-btn" <?php if($stok==0) echo "disabled"; ?>>
        <?php echo $stok>0 ? "Pesan" : "Stok Habis"; ?>
      </button>
    </form>
  </div>
</div>
<script>
const cekbox = document.getElementById('cekbox');
const pesanBtn = document.querySelector('.order-btn');
cekbox.addEventListener('change', function(){pesanBtn.disabled = !this.checked && pesanBtn.disabled===false ? false : pesanBtn.disabled;});
</script>
</body>
</html>
