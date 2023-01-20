<!-- Reprogramed By safan masera buana paksi -->
<?php 
include 'action.php';
if (isset($_SESSION["login"])) {
echo "<script>
        document.location.href='index.php';
        </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Checkout</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" ><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Mobile Store</a>
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Selamat Datang Di Web Store Kami</h4>
        <div class="jumbotron p-3 mb-2 text-center">
          <h5><b>Silahkan Login Terlebih Dahulu</b></h5>
        </div>
        <form action="action.php" method="post" >
          <div class="form-group">
            <input type="text" name="nama" class="form-control" placeholder="Enter Nama" required>
          </div>
          <div class="form-group">
            <input type="password" name="pass" class="form-control" placeholder="Enter password" required>
          </div>
          <div class="form-group">
            <input type="submit" name="login" value="Login" class="btn btn-danger btn-block">
            <a  href="daftar.php"  class="btn btn-success btn-block">Daftar</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>
</html>