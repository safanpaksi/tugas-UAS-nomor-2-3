<!-- Reprogramed By safan masera buana paksi -->
<?php
	session_start();
	require 'config.php';

if (isset($_POST['daftar'])):
	  $nama = filter_var($_POST['nama'],FILTER_SANITIZE_STRING);
	  $pass = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
	  $nohp = filter_var($_POST['nohp'],FILTER_SANITIZE_STRING);
	  $alamat = filter_var($_POST['alamat'],FILTER_SANITIZE_STRING);
	  $n=openssl_encrypt($nama,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  $p=sha1($pass);
	  $no=openssl_encrypt($nohp,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  $al=openssl_encrypt($alamat,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  $query = $conn->prepare("INSERT INTO member  VALUES ('','$n','$p','$no','$al')");
	  $query->execute();
	  $row= mysqli_affected_rows ($conn);
	  if($row==1):
	  echo "
		<script>
		alert('Sekarang anda jadi member') 
         document.location.href='login.php';
  			</script>";
	  else:
	  	echo "<script>
		alert('Gagal jadi member') 
         document.location.href='daftar.php';
  			</script>";
	  endif;

endif;
if (isset($_POST['login'])):
	  $nama = filter_var($_POST['nama'],FILTER_SANITIZE_STRING);
	  $pass = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
	  $n=openssl_encrypt($nama,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  $p=sha1($pass);
	  $query =mysqli_query($conn,"SELECT * FROM member WHERE nama='$n' AND pass='$p'");
	  if($query->num_rows>0):
	  	$_SESSION["login"]=true;
	  echo "
		<script>
		alert('Berhasil Login') 
         document.location.href='index.php';
  			</script>";
	  else:
	  	echo "<script>
		alert('Gagal jadi member') 
         document.location.href='daftar.php';
  			</script>";
	  endif;

endif;

	// Add products into the cart table
	if (isset($_POST['pid'])) {
	  $pid = filter_var($_POST['pid'],FILTER_SANITIZE_STRING);
	  $pname = filter_var($_POST['pname'],FILTER_SANITIZE_STRING);
	  $pprice = filter_var($_POST['pprice'],FILTER_SANITIZE_STRING);
	  $pimage = filter_var($_POST['pimage'],FILTER_SANITIZE_STRING);
	  $pcode = filter_var($_POST['pcode'],FILTER_SANITIZE_STRING);
	  $pqty =$_POST['pqty'];
	  $total_price = $pprice * $pqty;

	  $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
	  $stmt->bind_param('s',$pcode);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['product_code'];

	  if (!$code) {
	  	$p1=openssl_encrypt($pname,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  	$p2=openssl_encrypt($pprice,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  	$p3=openssl_encrypt($pimage,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  	$p5=openssl_encrypt($total_price,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  	$p6=openssl_encrypt($pcode,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	    $query = $conn->prepare('INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)');
	    $query->bind_param('ssssss',$p1,$p2,$p3,$pqty,$p5,$p6);
	    $query->execute();

	    echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your cart!</strong>
						</div>';
	  } else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item already added to your cart!</strong>
						</div>';
	  }
	}

	// Get no.of items available in the cart table
	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  $stmt = $conn->prepare('SELECT * FROM cart');
	  $stmt->execute();
	  $stmt->store_result();
	  $rows = $stmt->num_rows;

	  echo $rows;
	}

	// Remove single items from cart
	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];

	  $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
	  $stmt->bind_param('i',$id);
	  $stmt->execute();

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}

	// Remove all items at once from cart
	if (isset($_GET['clear'])) {
	  $stmt = $conn->prepare('DELETE FROM cart');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}

	// Set total price of the product in the cart table
	if (isset($_POST['qty'])) {
	  $qty = filter_var($_POST['qty'],FILTER_SANITIZE_STRING);
	  $pid = filter_var($_POST['pid'],FILTER_SANITIZE_STRING);
	  $pprice = filter_var($_POST['pprice'],FILTER_SANITIZE_STRING);
	  $tprice = $qty * $pprice;
	  $t=openssl_encrypt($tprice,"aes-256-cbc","abnsbsbwj10j29sjsj","0","ijkosnheju38910j");
	  $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
	  $stmt->bind_param('isi',$qty,$t,$pid);
	  $stmt->execute();
	}

	// Checkout and save customer info in the orders table
	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
	  $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
	  $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
	  $products = filter_var($_POST['products'],FILTER_SANITIZE_STRING);
	  $grand_total = filter_var($_POST['grand_total'],FILTER_SANITIZE_STRING);
	  $address = filter_var($_POST['address'],FILTER_SANITIZE_STRING);
	  $pmode = filter_var($_POST['pmode'],FILTER_SANITIZE_STRING);

	  $data = '';

	  $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
	  $stmt->bind_param('sssssss',openssl_decrypt($name,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($email,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($phone,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($address,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($pmode,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($products,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'),openssl_decrypt($grand_total,'aes-256-cbc','abnsbsbwj10j29sjsj','0','ijkosnheju38910j'));
	  $stmt->execute();
	  $stmt2 = $conn->prepare('DELETE FROM cart');
	  $stmt2->execute();
	  $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
								<h2 class="text-success">Pesanan Kamu Dalam Perjalan!</h2>
								<h4 class="bg-danger text-light rounded p-2">Produk Yang Kamu Beli : ' . $products . '</h4>
								<h4>Nama Kamu : ' . $name . '</h4>
								<h4>E-mail Kamu : ' . $email . '</h4>
								<h4>NO Hp Kamu : ' . $phone . '</h4>
								<h4>Total Bayar : Rp. ' . number_format($grand_total,2) . '</h4>
								<h4>Mode Pembayaran : ' . $pmode . '</h4>
						  </div>';
	  echo $data;
	}
?>