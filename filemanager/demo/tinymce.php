<?php
define('VTD_System_Route',1);
include '../../VTD_system/VTD_load.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<textarea></textarea>
	
	<script src="<?=system::asset(null,"public/assets/tinymce/tinymce.min.js")?>"></script>
	<script src="<?=system::asset(null,"public/assets/fancybox/jquery.fancybox.pack.js")?>"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
		  selector: 'textarea',
		  height: 500,
		  menubar: false,
		  plugins: [
		    'advlist autolink lists link image charmap print preview anchor',
		    'searchreplace visualblocks code fullscreen',
		    'insertdatetime media table contextmenu paste code',
		    'table contextmenu directionality emoticons paste textcolor responsivefilemanager code'
		  ],
		  toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		  image_advtab: true ,
		  filemanager_crossdomain: true,
		  external_filemanager_path:"<?=system::base_url()?>/filemanager/", 
		  filemanager_title:"Quản Lý File", 
		  filemanager_access_key:"myPrivateKey",
		  external_plugins: { "filemanager" : "<?=system::asset(null,"/filemanager/plugin.min.js")?>"},
		  content_css: [
		    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		    '//www.tinymce.com/css/codepen.min.css']
		});
	</script>
</body>
</html>