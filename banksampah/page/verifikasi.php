<?php
  include '../system/config/koneksi.php';
  $nin        = $_GET['nin'];
  $data_admin = mysqli_query($conn, "UPDATE nasabah SET status = 'verifikasi' WHERE nin = '$nin'");
  echo "
    <script>
      window.location.replace('http://localhost/bank_sampah/banksampah/page/login.php');
    </script>
  ";
?>