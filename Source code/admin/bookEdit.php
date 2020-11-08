<?php 
	include_once('../config/database_book.php');
?>
<?php 
	# Lấy DL truyền đến
	if(isset($_GET["bid"])== true){
		$bookID = $_GET["bid"];
		$theloaiID = $_GET["tl"];
	} else {
		header("location: ../index.php");
		die;
	}

?>
<?php 
	# B1. Kết nối vào CSDL
	$connection = mysqli_connect($server, $svuser, $svpass, $dbname);
	
	if(mysqli_connect_errno()==true){
		$errMsg = mysqli_connect_error();
		echo "<p style='color: red;'>Lỗi kết nối. Vui lòng kiếm tra database $errMsg</p>";
	}

	# Chuyển sang tiếng Việt
	mysqli_query($connection, "SET CHARACTER SET utf8");

	# B2. Viết câu lệnh SQL lấy dữ liệu
	$sql = "select * from Sach where IDSach = $bookID;";

	# B3. Thực hiện lệnh SQL qua PHP
	$data = mysqli_query($connection, $sql);

	# B4. Nhận/ xử DL nếu có
	while ($dongDuLieu = mysqli_fetch_array($data, MYSQLI_ASSOC)){
		$bTenSach = $dongDuLieu["TenSach"];
		$bGiaBan = $dongDuLieu["GiaBan"];
		$bSoLuong = $dongDuLieu["SoLuong"];
		$bTheLoai = $dongDuLieu["ThuocTL"];
		$bURLHinh = $dongDuLieu["URLHinh"];
	}
?>

<?php 
	# TẠO THỂ LOẠI SÁCH
	# B1. Kết nối vào CSDL
	$connection = mysqli_connect($server, $svuser, $svpass, $dbname);

	if(mysqli_connect_errno()==true){
		$errMsg = mysqli_connect_error();
		echo "<p style='color: red;'>Lỗi kết nối dữ liệu. Vui lòng kiếm tra database $errMsg</p>";
	}

	# Chuyển sang tiếng Việt
	mysqli_query($connection, "SET CHARACTER SET utf8");

	# B2. Viết câu lệnh SQL lấy dữ liệu
	$sql = "select * from theloaisach order by TenTL";

	# B3. Thực hiện lệnh SQL qua PHP
	$data = mysqli_query($connection, $sql);

	# B4. Nhận/ xử DL nếu có
	$htmlOption = "";
	while ($dongDuLieu = mysqli_fetch_array($data, MYSQLI_ASSOC)){
		$idTL = $dongDuLieu["IDTL"];
		$tenTL = $dongDuLieu["TenTL"];

		$selected = ($idTL == $bTheLoai) ? ("selected") : ("");
		$htmlOption .= "<option $selected value='$idTL'>$tenTL</option>";
	}
	# B5. Ngắt kết nối DL
	mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hiệu chỉnh sách</title>
</head>
<body>
	<h1>Hiệu chỉnh thông tin sách</h1>
	<hr>
	<form action="bookEditSave.php" method="POST">
		<input type="hidden" size="100" name="bookID" value="<?php echo $bookID; ?>" />
		<div>Tên sách <input type="text" size="100" name="bTenSach"
			value="<?php echo $bTenSach; ?>"/></div>
		<div>Giá bán <input type="text" size="100" name="bGiaBan"
			value="<?php echo $bGiaBan; ?>"/></div>
		<div>Số lượng <input type="text" size="100" name="bSoLuong"
			value="<?php echo $bSoLuong; ?>"/></div>
		<div>Thể loại
			<select name="bTheLoai"><?php echo $htmlOption; ?></select>
		</div>

		<div>Hình ảnh <input type="text" size="100" name="bURLHinh"
			value="<?php echo $bURLHinh; ?>"/></div><br/>
		<div>
			<input type="submit" value="Lưu" onclick="editAlert()" />
		</div>
	</form>
	<button onclick="history.go(-1)">Thoát</button>
	
</body>
<script type="text/javascript">
	function editAlert(){
		alert('Cập nhật thành công');
	}
</script>
</html>