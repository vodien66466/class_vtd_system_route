<?php
$vtd_config = [
		'basePath' => '', // Thư mục lưu code
		'rootDir' => dirname(dirname(__FILE__)), // lấy path
		'lang' => 'vi', // ngôn ngữ
		'image_error' => 'public/images/ERROR.PNG',
		'debug' => false, // bật tắt báo lỗi (false,true)
		'timezone' => 'Asia/Ho_Chi_Minh', // múi giờ 
		'theme' => 'real-estates/BDS',
		'url_rewrite' => false,
		'password_it' => "", // không có cũng được, k quan trọng
		'db' => [
			'enable' => false, // bật tắt kết nối sql (false,true)
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'dbname' => ''
		]
	];
?>
