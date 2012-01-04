<!doctype html>
<html lang="<?php echo I18n::$lang ?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
	</head>
	<body>
		<div id="forecast">
			<?php echo $content ?>
		</div>
	</body>
</html>