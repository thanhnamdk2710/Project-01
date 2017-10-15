<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Administration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<!-- Liên kết Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo $_DOMAIN; ?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/common.css">
	<!-- Liên kết thư viện JQuery -->
	<script src="<?php echo $_DOMAIN; ?>js/jquery.min.js"></script>
</head>
<body>
	<?php
		// Nếu chưa đăng nhập
		if (!$user) {
	?>
		<div class="container">
			<div class="page-header">
				<h1>CDNNT <small>Administrator</small></h1>
			</div><!--/.page-header-->
		</div><!--/.container-->
	<?php
		// Nếu đăng nhập
		} else {
	?>
		<nav class="navbar navbar-default" role='navigation'>
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="<?php echo $_DOMAIN; ?>" class='navbar-brand'><h1>CDNNT Administrator</h1></a>
				</div><!--/.navbar-header-->
			</div><!--/.container-fluid-->
		</nav><!--/.navbar-->
	<?php
		}
	?>