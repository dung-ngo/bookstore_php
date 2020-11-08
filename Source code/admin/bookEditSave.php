<?php 
	include_once('../config/database_book.php');

	# Lấy DL sách được truyền đến
	if(isset($_POST['bookID']) == false){
		header('location: ../index.php');
	}
	$bookID = $_POST["bookID"];
	$bTenSach = $_POST["bTenSach"];
	$bGiaBan = $_POST["bGiaBan"];
	$bSoLuong = $_POST["bSoLuong"];
	$bTheLoai = $_POST["bTheLoai"];
	$bURLHinh = $_POST["bURLHinh"];


	# B1. Kết nối vào CSDL
	$connection = mysqli_connect($server, $svuser, $svpass, $dbname);
	// mysqli_connect(serverHost,serverUser,serverPass, databaseName)
	
	if(mysqli_connect_errno() == true){
		$errMsg = mysqli_connect_error();
		echo "<p style='color: red;'>Lỗi kết nối. $errMsg</p>";
		exit();
	}

	# Chuyển sang tiếng Việt
	mysqli_query($connection, "SET CHARACTER SET utf8");

	# B2. Viết câu lệnh SQL lấy dữ liệu
	$sql = "Update Sach Set
				TenSach='$bTenSach',
				GiaBan=$bGiaBan,
				SoLuong=$bSoLuong,
				ThuocTL='$bTheLoai',
				URLHinh='$bURLHinh'
			where IDSach=$bookID ;";

	# B3. Thực hiện lệnh SQL qua PHP
	$data = mysqli_query($connection, $sql);
	$urlBack = "../home.php?tl=$bTheLoai";
	header("location: $urlBack");

	# B5. Ngắt kết nối DL
	mysqli_close($connection);

?>
