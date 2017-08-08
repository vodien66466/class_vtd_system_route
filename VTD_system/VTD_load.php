<?php
defined('VTD_System_Route') or die();
//file config website
include 'VTD_config/VTD_main.php';
// xử lý bất tắt báo lỗi
if ($GLOBALS['vtd_config']['debug']==true) {
	error_reporting(0);
}
// thiết lặp múi giờ cho hệ thống (PHP 5 >= 5.1.0).
date_default_timezone_set($GLOBALS['vtd_config']['timezone']);
//sission
session_start();
//để hàm header() hoạt động không lỗi
ob_start();

// Khởi tạo Object 
include('VTD_class/VTD_system.php');
//$s = new system;
new system;
//include('VTD_class/VTD_data.php');
//$d = new data;
//kết nối csdl
if ($GLOBALS['vtd_config']['db']['enable']==true) {
	$db_connect = new mysqli($GLOBALS['vtd_config']['db']['host'],$GLOBALS['vtd_config']['db']['user'],$GLOBALS['vtd_config']['db']['password'],$GLOBALS['vtd_config']['db']['dbname']);
	if ($db_connect->connect_error) {
	    die("Kết nối thất bại: " . $conn->connect_error);
	} else {
		include('VTD_class/VTD_data.php');
		new data;
	}
}
//
$settings_array=data::key('vtd_settings');
/*
spl_autoload_register('autoload');
function autoload($name)
{
    $file ='VTD_class/' . $name . '.php';
    if (file_exists($file))
        require_once($file);
}
new VTD_system;
*/
$view = isset($_GET['VTD_view']) ? trim($_GET['VTD_view']) : '';

// xử lý nhận diện lỗi hệ thống và dừng toàn bộ hoạt động
function exception_handler($exception) {
	echo "Báo lỗi: " , $exception->getMessage(), "\n";
}
set_exception_handler('exception_handler');

?>