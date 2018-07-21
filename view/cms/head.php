<?php 
if (!defined('SECURITY_KEY') ){ exit($mvc_lang_error['security_key']); }
if(SETUP_SHOW_PATH){ developMode(__FILE__);}
$random = rand(100,999);
?>
<!DOCTYPE html>
<html lang="es" >
	<head>
		<title>BASIC MVC </title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Josefin+Sans" />
		<link rel="stylesheet" type="text/css" href="<?php echo SETUP_THEME_ABS_PATH; ?>css/main2.css?random=<?php echo rand(10,100);?>" >
		<link rel="stylesheet" type="text/css" href="<?php echo SETUP_THEME_ABS_PATH; ?>css/style.css?random=<?php echo rand(10,100);?>" >
		
		<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
		<script src="<?php echo SETUP_THEME_ABS_PATH; ?>js/function.js"></script>
	<head>
	<body>