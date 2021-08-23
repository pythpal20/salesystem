<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mr. Kitchen</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
	<div class="middle-box text-center loginscreen animated fadeInDown">
		<div>
			<div>
				<div  class="d-flex justify-content-center">
					<img style="width:100%" src="../img/mkc.png">
				</div>
			</div>
			<h3>Selamat Datang</h3>
			<p>Aplikasi Sales System 1.0 | Silahkan Login</p>
			<form class="m-t" role="form" action="login_proses.php" method="POST">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username" required="">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password" required="">
				</div>
				<button type="submit" style="background-color:#ff0000;color:white" class="btn block full-width m-b">Login</button>
			</form>
			<p class="m-t"> <small>Mr.Kitchen | IT Team &copy; 2021</small> </p>
		</div>
	</div>
	<script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.js"></script>
</body>
</html>