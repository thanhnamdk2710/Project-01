<?php
	// Lớp session
	class Session{
		// Hàm bắt đầu Session
		public function start(){
			session_start();
		}

		// Hàm lưu Session
		public function send($user){
			$_SESSION['user'] = $user;
		}

		// Hàm lấy dữ liệu Session
		public function get(){
			if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
			} else {
				$user = '';
			}
			return $user;
		}

		// Hàm xóa Session
		public function destroy(){
			session_destroy();
		}
	}
?>