<?php

$type  = $_REQUEST['type']  ?? $_REQUEST['t'] ?? false;
$icon  = $_REQUEST['icon']  ?? $_REQUEST['i'] ?? false;
$color = $_REQUEST['color'] ?? $_REQUEST['c'] ?? false;

if ($type && $icon) {

	$path = __DIR__ . "/svgs/$type/$icon.svg";

	if (!file_exists($path)) {
		echo json_encode([
			'path' => $path,
			'error' => 'The icon you requested does not exist!',
			'success' => false
		]);
		exit;
	}

	$svg = file_get_contents($path);
	$style = '';

	if ($color) {
		$id = '_' . uniqid();
		$svg = str_replace('<svg ', "<svg id=\"$id\" ", $svg);

		$style = "<style>#$id * {fill:$color;}</style>";
	}

	echo $style . $svg;
} else {
	echo json_encode([
		'error' => 'To use this you must add what FontAwesome `type` (e.g. brands, light, solid) and `icon` (e.g. alien, hands, shapes) you want!',
		'success' => false
	]);
}
