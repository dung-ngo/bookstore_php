<?php
	session_start();
	$user = $_SESSION["user"];
?>
<?php 
	include_once('config/database_book.php');
?>
<?php 
	# =============Lấy dữ liệu thể loại sách từ DB==================
	# B1. Kết nối vào CSDL
	$connection = mysqli_connect($server, $svuser, $svpass, $dbname);
	
	if(mysqli_connect_errno()==true){
		$errMsg = mysqli_connect_error();
		echo "<p style='color: red;'>Lỗi kết nối. $errMsg</p>";
	} 

	# Chuyển sang tiếng Việt
	mysqli_query($connection, "SET CHARACTER SET utf8");

	# B2. Viết câu lệnh SQL lấy dữ liệu
	$sql = "select * from theloaisach order by TENTL";

	# B3. Thực hiện lệnh SQL qua PHP
	$data = mysqli_query($connection, $sql);

	# B4. Nhận/ xử DL nếu có
	$htmlDanhMuc = "";
	while ($dongDuLieu = mysqli_fetch_array($data, MYSQLI_ASSOC)){
		$idTL = $dongDuLieu["IDTL"];
		$tenTL = $dongDuLieu["TenTL"];
		$url = "<a href='home.php?tl=$idTL'>$tenTL</a>";
		$htmlDanhMuc .= "<p>$url</p>";
	}
?>

<?php 
	# =============Lấy dữ liệu đầu sách theo TL từ DB==================
	if(isset($_GET['tl'])==true)
		$tl = $_GET['tl'];
	else
		$tl = '';

	# B2. Viết câu lệnh SQL lấy dữ liệu
	$sql = "select IDSach, TenSach, URLHinh, GiaBan, SoLuong from Sach where ThuocTL='$tl'";

	# B3. Thực hiện lệnh SQL qua PHP
	$data = mysqli_query($connection, $sql);

	# B4. Nhận/ xử DL nếu có
	$htmlDSSach = "";
	while ($dongDuLieu = mysqli_fetch_array($data, MYSQLI_ASSOC)){
		$idS = $dongDuLieu["IDSach"];
		$tenS = $dongDuLieu["TenSach"];
		$urlHinh = $dongDuLieu["URLHinh"];
		$giaS = $dongDuLieu["GiaBan"];
		$slgS = $dongDuLieu["SoLuong"];
		$urlEdit = "admin/bookEdit.php?bid=$idS&tl=$tl";

		$htmlDSSach .= "
			<div style='padding: 20px;'>
				<div class='dm' style='float: left; width: 10%'>
					<img src='$urlHinh' width='100%';/>
				</div>
				<div class='sach' style='float: left; padding-left: 4%'>
					<b>$tenS</b> <br/>
					<span>Giá bán: $giaS</span> <br/>
					<span>Số lượng: $slgS</span> <br/>
					<hr>
					<a href='$urlEdit' id='editBtn'>Hiệu chỉnh</a>
				</div>
				<div style='clear:both'></div>
			</div>
		";
	}
	# B5. Ngắt kết nối DL
	mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Semi's bookstore</title>
	<link rel="stylesheet" href="asset/style.css"/>
</head>
<body>
	<div class="top-info">
		<ul>
			<li>Chào <span style="color:blue;font-weight: bold;"><?php echo $user; ?> </span></li> |
			<li>
				<form action='admin/user/update.php' method='post'>
	 				<input class="decorBtn" type='submit' name='updateBtn' value='Tùy chỉnh'> |
				</form>
			</li>
			<li>
				<form action='admin/user/logout.php' method='post'>
	 				<input class="decorBtn" type='submit' name='logout' value='Đăng xuất'>
				</form>
			</li>
		</ul>
	</div>
	<h1>Chào mừng đến với Semi's bookstore</h1>
	<div class="book-content">
		<div style="float: left; width: 10%; background: lightblue; padding: 20px;">
			<b>Danh mục sách</b>
			<?php echo $htmlDanhMuc; ?>
		</div>
		<div style="float: right; width: 82%; padding: 20px">
			<b>Các đầu sách tương ứng</b>
			<?php echo $htmlDSSach; ?>
		</div>
	</div>
</body>
</html>
