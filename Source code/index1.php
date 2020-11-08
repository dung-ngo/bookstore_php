<?php 
session_start();

$output = "";
if(!isset($_SESSION["user"])){
	$output = "
			<div>
				<p>Bạn vui lòng đăng nhập để xem nội dung <a href='admin/user/login.php'>Đăng nhập</a></p>
				<p>Bạn chưa có tài khoản? Bấm vào <a href='admin/user/signup.php'>đây</a> để đăng ký</p>
			</div>

			";
} else {
	// $user = $_SESSION["user"];
	// $output = "<div>
	// 				<p>Xin chào bạn <b>$user</b></p>
					
	// 					<form action='admin/user/logout.php' method='post'>
	// 						<input type='submit' name='logout' value='Đăng xuất'>
	// 					</form>
	// 					<form action='admin/user/delete.php' method='post'>
	// 						<input type='submit' name='delete' value='Xóa tài khoản'>
	// 					</form>
	// 					<form action='admin/user/update.php' method='post'>
	// 						<input type='submit' name='updateBtn' value='Cập nhật thông tin'>
	// 					</form>
	// 			</div>";
	header("location: home.php");
}



?>
<html>
	<head>
		<title>PHP Blog</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<a href="admin/user/login.php">Trang Đăng nhập </a>|
		<a href="admin/user/signup.php">Trang Đăng ký</a>
		<div>
			<h1>Chào mừng bạn đến với DUNG'S PHP BLOG</h1>
			<?php echo $output; ?>	
		</div>
	</body>
</html>