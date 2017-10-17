<?php
	// Sidebar left
	require_once 'templates/sidebar-left.php';
?>

<!--====================Main=====================-->
<article class="content col-md-6 block">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="fa fa-graduation-cap"></span> Thông tin góp ý
			</h3>
		</div>
		<div class="panel-body">
			<p class="text text-warning"><b style="color: red;">*</b> Vui lòng điền đầy đủ thông tin</p>
			<form method="POST" id="formFeedback" onsubmit="return false;">
				<div class="form-group">
					<label for="name">Họ và tên:</label>
					<input type="text" class="form-control" id="name" placeholder="Nhập họ tên...">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" placeholder="Nhập email...">
				</div>
				<div class="form-group">
					<label for="phone">Điện thoại:</label>
					<input type="tell" class="form-control" id="phone" placeholder="Nhập số điện thoại...">
				</div>
				<div class="form-group">
					<label for="body">Nội dung:</label>
					<textarea id="body" rows="3" class="form-control" placeholder="Nhập nội dung..."></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Góp ý</button>
				</div>
				<div class="alert alert-danger hidden"></div>
			</form>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="fa fa-graduation-cap"></span> Bản đồ
			</h3>
		</div>
		<div class="panel-body">
			<iframe width="100%" height="350" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1949.7562006210303!2d109.2074809304709!3d12.213545491356411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170674637000ac9%3A0x51fd8a017075f390!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIG5naOG7gSBOaGEgVHJhbmc!5e0!3m2!1svi!2s!4v1475548509153"></iframe>
		</div>
	</div>
</article>

<?php
	// Sidebar right
	require_once 'templates/sidebar-right.php';
?>