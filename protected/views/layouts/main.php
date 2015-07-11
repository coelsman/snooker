<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/page.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/base.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		
	</div><!-- header -->

	<div style="position:relative;">
		<div id="alert-site" class="hide" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="alert-content"></div>
		</div>
		<div id="mainMenu" class="col-md-3">
			<ul class="nav nav-pills nav-stacked">
				<?php 
					$className = '';
					$arrRequest = array(array('', 'Home'), array('site/player', 'Player'), array('site/match', 'Match'), array('site/tournament', 'Tournament'), array('site/season', 'Season'), array('site/ranking', 'Ranking'));
					foreach ($arrRequest as $key => $value) {
						if ($_REQUEST) {
							if ($_REQUEST['r'] == $value[0]) {
								$className = 'active';
							} else {
								$className = '';
							}
						}
						echo '<li role="presentation" class="'.$className.'"><a href="'.Yii::app()->createUrl($value[0]).'">'.$value[1].'</a></li>';
					}
				?>
			</ul>
		</div>
		<div id="leftContent" class="col-md-9">
			<?php echo $content; ?>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="footer">
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
