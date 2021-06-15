<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  require_once("../system/config/koneksi.php");
  $no   = mysqli_query($conn, "SELECT nin FROM nasabah ORDER BY nin DESC");
  $nin  = mysqli_fetch_array($no);
  $kode = $nin['nin'];

  $urut   = substr($kode, 7, 3);
  $tambah = (int) $urut + 1;
  $bln    = date("m");
  $thn    = date("y");

  if(strlen($tambah) == 1){
    $format = "NSB".$thn.$bln."00".$tambah;
  }else if (strlen($tambah) == 2) {
    $format = "NSB".$thn.$bln."0".$tambah;
  }else{
    $format = "NSB".$thn.$bln.$tambah;
  }

  if(isset($_POST['simpan'])){
    $nin      = $_POST['nin'];
    $nama     = $_POST['nama'];
    $rt       = $_POST['rt'];
    $alamat   = $_POST['alamat'];
    $telepon  = $_POST['telepon'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $saldo    = $_POST['saldo'];
    $sampah   = $_POST['sampah'];

    $sql  = mysqli_query($conn, "SELECT * FROM nasabah WHERE nin = '$nin'");

    if (mysqli_fetch_array($sql) > 0) {
      echo "
        <script>
          alert('Maaf akun sudah terdaftar');
        </script>";

      echo "<meta http-equiv='refresh'
      content='0; url=http://localhost/bank_sampah/banksampah/page/register.php'>";

      return FALSE;      
    }

    mysqli_query($conn, "INSERT INTO nasabah VALUES ('$nin', '$nama', '$rt', '$alamat', '$telepon', '$email', '$password', '$saldo', '$sampah', 'belum_verifikasi')");
    
    require '../../vendor/autoload.php';
    
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'fieryinferno33@gmail.com';                     //SMTP username
      $mail->Password   = 'NaonWeAh00';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('fieryinferno33@gmail.com', 'Bank Sampah');
      $mail->addAddress('bagassetia271@gmail.com');
      
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Verifikasi User';
      $mail->Body    = 'http://localhost/bank_sampah/banksampah/page/verifikasi.php?nin=' . $nin;

      $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    echo "
      <script>
        alert('Selamat berhasil input data!');
      </script>";

    echo "<meta http-equiv='refresh'
    content='0; url=http://localhost/bank_sampah/banksampah/page/register.php'>";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Register</title>
	<link rel="stylesheet" href="../asset/internal/css/style_1.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:700" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="../asset/internal/img/img-local/favicon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <style>

    label{
      font-family : Montserrat;    
      font-size   : 18px;
      display     : block;
      color       : #262626;
    }

    input[type=text], input[type=password]{
      border-radius : 5px;
      width         : 40%;
      height        : 35px;
      background    : #eee;
      padding       : 0 10px;
      box-shadow    : 1px 2px 2px 1px #ccc;
      color         : #262626;
    }

    select{
      border-radius : 5px;
      width         : 42%;
      height        : 38px;
      background    : #eee;
      padding       : 0 10px;
      box-shadow    : 1px 2px 2px 1px #ccc;
      color         : #262626;
    }

    input[type=submit]{
      height        : 35px;
      width         : 200px;
      background    : #8cd91a;
      border-radius : 20px;
      color         : #fff;
      margin-top    : 20px;
      cursor        : pointer;
    }

    input, select{
      font-family : Montserrat;
      font-size   : 16px;
    }

    .form-group{
      padding : 5px 0;
    }
  </style>  
  <script type="text/javascript">
    function cek_data() {
      var x   = daftar_user.nama.value;
      var x1  = parseInt(x);
       
      if(x  == ""){
        alert("Maaf harap input nama nasabah!");
        daftar_user.nama.focus(); 
        return false;
      } 
      if(isNaN(x1)==false){
        alert ("Maaf nama harus di input huruf!");
        daftar_user.nama.focus();
        return false;
      }
      var p = daftar_user.rt.value;
      if (p =="p"){
        alert("Maaf harap input rukun tetangga (RT)!");
        return (false); 
      }
      var x   = daftar_user.alamat.value;
      var x1  = parseInt(x);
       
      if(x==""){
        alert("Maaf harap input alamat nasabah!");
        daftar_user.alamat.focus(); 
        return false;
      }
      var x     = daftar_user.telepon.value;
      var angka = /^[0-9]+$/;

      if(x==""){
        alert("Maaf harap input nomor telepon!");
        daftar_user.telepon.focus();  
        return false;
      }
      if (!x.match(angka)) {
        alert ("Maaf nomor telepon harus di input angka!");
        daftar_user.telepon.focus();
        return false;
      }
      if(x.length!=12){
        alert("Nomor telepon harus 12 karakter!");
        daftar_user.telepon.focus();
        return false;
      }
      var x         = daftar_user.email.value;
      var cek_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

      if(x  == ""){
        alert("Maaf harap input email!");
        daftar_user.email.focus(); 
        return false;
      }
      if(!x.match(cek_email)){
        alert("Format penulisan email tidak sesuai!");
        daftar_user.email.focus();
        return false;
      }
      var x       = daftar_user.password.value;
      var panjang = x.length;

      if(x==""){
        alert("Maaf harap input password!");
        daftar_user.password.focus(); 
        return false;
      }
      if(panjang<6 || panjang>20){
          alert("Password di input minimum 6 karakter dan maksimum 20 karakter!");
          daftar_user.password.focus();
          return false;
      }else{
      confirm("Apakah Anda yakin sudah input data dengan benar?");
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"></div>
          <div class="card-body">
            <h1>Register</h1>
            <form id="daftar_user" action="" method="post" onsubmit="return cek_data()">
              <div class="form-group">
                <label class="text-left">Nomor Induk Nasabah</label>
                <input style="cursor: not-allowed;" type="text" name="nin" value="<?php echo $format; ?>" readonly/>
              </div>

              <div class="form-group">
                <label class="left">Nama Nasabah</label>
                <input type="text" name="nama" placeholder="Masukan nama nasabah" />
              </div>

              <div class="form-group">
                <label class="">Rukun Tetangga (RT)</label>
                  <select name="rt">
                    <option value="p">---Pilih RT---</option>
                    <option value="1">RT01</option>
                    <option value="2">RT02</option>
                    <option value="3">RT03</option>
                    <option value="4">RT04</option>
                    <option value="5">RT05</option>
                    <option value="6">RT06</option>
                    <option value="7">RT07</option>
                    <option value="8">RT08</option>
                    <option value="9">RT09</option>
                </select>
              </div>

              <div class="form-group">
                <label class="">Alamat</label>
                <input type="text" placeholder="Masukan alamat" name="alamat" />
              </div>

              <div class="form-group">
                <label class="">Nomor Telepon</label>
                <input type="text" placeholder="Masukan nomor telepon" name="telepon" />
              </div>

              <div class="form-group">
                <label class="">E-mail</label>
                <input type="text" placeholder="Masukan alamat email" name="email" />
              </div>

              <div class="form-group">
                <label class="">Password</label>
                <input type="password" placeholder="Masukan password" name="password" />
              </div>

              <div class="form-group">
                <input type="hidden" name="saldo" />
              </div>
              <div class="form-group">
                <input type="hidden" name="sampah" />
              </div>

              <input type="submit" name="simpan" value="Simpan"></input>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>