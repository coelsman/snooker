<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/client.css" />

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/base.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/object/CountryCode.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="" id="page">

	<div id="header">
		<nav class="navbar navbar-inverse">
			<div id="wrap_header_center">
				<img class="pull-right" src="images/home_icon.png">
			</div>
		</nav>
	</div><!-- header -->

	<div id="content">
		<div id="content-left">
			<ul>
				<li>Test menu left</li>
				<li>Test menu left</li>
				<li>Test menu left</li>
				<li>Test menu left</li>
				<li>Test menu left</li>
			</ul>
		</div>
		<div id="content-center"><?php echo $content; ?></div>
		<div id="content-right">
			<ul>
				<li>Test menu right</li>
				<li>Test menu right</li>
				<li>Test menu right</li>
				<li>Test menu right</li>
				<li>Test menu right</li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="footer">
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
