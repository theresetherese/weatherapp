<!doctype html>
<html lang="<?php echo I18n::$lang ?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
		<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
	</head>
	<body>
		<h1>Weather</h1>
		<div id="searchForm">
			<h2>Search for a city</h2>
			<?php
				echo Form::open('');
				echo Form::input('searchInput', '', array('id' => 'searchInput'));
				echo Form::submit('searchSubmit', 'Search', array('id' => 'searchSubmitBtn'));
  				echo Form::close();
			?>
		</div>
		<div id="searchResult"></div>
		<div id="latestSearches"></div>
		<div id="forecast">
			<?php echo $content ?>
		</div>
	</body>
</html>