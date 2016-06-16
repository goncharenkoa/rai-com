<!DOCTYPE HTML>
<html>
<head>
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro|Open+Sans:300,300italic,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="velocity-page-wrapper">
	<?php VelocityPage()->page()->render(); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
