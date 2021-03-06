<?
require_once("config.php");


ob_start("callback");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="#">
	<title>Dailymotion</title>

	<!-- Bootstrap -->
	<link href="/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

	<script type="text/javascript" src="../js/jquery.min.js?v=201300818"></script>
	<script type="text/javascript" src="../js/jwysiwyg/jquery.wysiwyg.js"></script>

	<!-- Custom styles -->
	<link rel="stylesheet" type="text/css" href="../css/stylecss/main.css"/>
	<link rel="stylesheet" type="text/css" href="../css/stylecss/styles.css"/>
<link rel="stylesheet" type="text/css" href="/css/css_theme.css"/>
<link rel="stylesheet" type="text/css" href="../css/stylecss/css_style.css"/>





	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<?php include '../inclue_video/inc_header.php'; ?>
<?php include '../inclue_video/inc_home.php'; ?>
<?php include '../inclue_video/inc_footer.php'; ?>
</body>
</html>