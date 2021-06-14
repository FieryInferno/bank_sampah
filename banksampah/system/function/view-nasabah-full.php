<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../datatables/css/jquery.dataTables.css">
	<style>
		label{
    font-family: Montserrat;    
    font-size: 18px;
    display: block;
    color: #262626;
    }
	</style>
</head>
<body>
	<h2 style="font-size: 30px; color: #262626;">Data Nasabah</h2>
	<br>
	<table id="example" class="display" cellspacing="0" width="100%" border="0" >
    <thead>
      <tr>
        <th>NIN</th>
        <th>Nama</th>
        <th>RT</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>E-mail</th>
        <th>Saldo</th>
        <th>Sampah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>NIN</th>
        <th>Nama</th>
        <th>RT</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>E-mail</th>
        <th>Saldo</th>
        <th>Sampah</th>
        <th>Aksi</th>       
      </tr>   
    </tfoot>
      <tbody>
        <?php
          $query = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY nin ASC");
          while($row = mysqli_fetch_assoc($query)){
        ?>
        <tr align="center">
          <td><?php echo $row['nin'] ?></td>
          <td><?php echo $row['nama'] ?></td>
          <td><?php echo $row['rt'] ?></td>
          <td><?php echo $row['alamat'] ?></td>
          <td><?php echo $row['telepon'] ?></td>
          <td><?php echo $row['email'] ?></td>
          <td>
            <?php
              $saldonya = mysqli_query($conn, "SELECT SUM(total) AS totalsaldo FROM setor WHERE nin='".$row['nin']."'");
              $tariknya = mysqli_query($conn, "SELECT SUM(jumlah_tarik) AS totaltarik FROM tarik WHERE nin='".$row['nin']."'");
              $var_saldo = mysqli_fetch_array($saldonya);$var_tarik = mysqli_fetch_array($tariknya);
              $tot_saldo_total=($var_saldo['totalsaldo'])-($var_tarik['totaltarik']);
              $saldoakhir = mysqli_query($conn, 
              "update nasabah SET saldo=$tot_saldo_total WHERE nin='".$row['nin']."'");                    
            ?>                    
            <?php echo "Rp. ".number_format($row['saldo'], 2, ",", ".")  ?></td>
          <td>
            <button type="button" data-toggle="modal" data-target="#exampleModal<?= $row['nin']; ?>">
              Lihat
            </button>
            
            <div class="modal fade" id="exampleModal<?= $row['nin']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table id="example" class="display" cellspacing="0" width="100%" border="0" >
                      <thead>
                        <tr>
                          <th>Tanggal Setor</th>
                          <th>Jenis Sampah</th>
                          <th>Harga</th>
                          <th>Berat</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Tanggal Setor</th>
                          <th>Jenis Sampah</th>
                          <th>Harga</th>
                          <th>Berat</th>
                          <th>Total</th>
                        </tr>   
                      </tfoot>
                      <tbody>
                        <?php
                          $querysampah  = mysqli_query($conn, "SELECT * FROM setor WHERE nin='".$row['nin']."'");
                          while ($key = mysqli_fetch_assoc($querysampah)) { 
                        ?>
                            <tr align="center">
                              <td><?php echo $key['tanggal_setor'] ?></td>
                              <td><?php echo $key['jenis_sampah'] ?></td>
                              <td><?php echo $key['harga'] ?></td>
                              <td><?php echo $key['berat'] ?></td>
                              <td><?php echo $key['total'] ?></td>
                            </tr>
                          <?php } 
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </td>
          <td>

              <a href="admin.php?page=edit-nasabah-id&id=<?php echo $row['nin']; ?>">
              <button><i class="fa fa-pencil"></i>edit</button> 
              </a>
              
              <a onclick="return confirm('Anda yakin ingin menghapus data ini?')" href="../system/function/delete-nasabah.php?id=<?php echo $row['nin']; ?>">
              <button><i class="fa fa-trash-o"></i>hapus</button>
              </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <br>
    <br>
    
    <a href="admin.php?page=tambah-data-nasabah">
    <button><i class="fa fa-plus" aria-hidden="true"></i>Tambah</button>
    </a>

    <a target="_blank" href="../system/function/excel-nasabah.php">
    <button><i class="fa fa-print" aria-hidden="true"></i>Excel</button>
    </a>
    
    <a target="_blank" href="../system/function/print-nasabah.php">
    <button><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
    </a>

    <script type="text/javascript" src="../datatables/js/jquery.min.js"></script>
    <script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
           $('#example').DataTable();
        } );
    </script>
</body>
</html>