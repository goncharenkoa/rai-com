<!DOCTYPE HTML>
<html>
<head>
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700|Pacifico' rel='stylesheet' type='text/css'>
</head>
<body <?php body_class(); ?>>
<div id="velocity-page-wrapper">
	<?php VelocityPage()->page()->render(); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
