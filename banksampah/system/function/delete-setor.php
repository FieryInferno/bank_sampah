<?php
  require_once("../config/koneksi.php");
  $id         = $_GET['id'];
  $data       = mysqli_query($conn, "SELECT * FROM setor WHERE id_setor = '$id'");
  $dataSetor  = mysqli_fetch_assoc($data);
  if (file_exists('../../asset/' . $dataSetor['dokumen_tanda_terima'])) {
    unlink('../../asset/' . $dataSetor['dokumen_tanda_terima']);
  }
  $query    = "DELETE FROM setor WHERE id_setor = '$id'";
  $queryact = mysqli_query($conn, $query);
  echo "
  <script>
    window.location.replace('http://localhost/bank_sampah/banksampah/page/admin.php?page=data-setor');
  </script>";
?>