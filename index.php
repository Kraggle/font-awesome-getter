<?php
header('Access-Control-Allow-Origin: *');

$file = './metadata/aliases.json';
if (!file_exists($file)) {
	$aliases = (object) [];
	$icons = json_decode(file_get_contents('./metadata/icons.json'));
	foreach ($icons as $name => $value) {
		if (isset($value->aliases->names)) {
			foreach ($value->aliases->names as $alias)
				$aliases->$alias = $name;
		}
	}

	file_put_contents($file, json_encode($aliases, JSON_PRETTY_PRINT));
}

$type  = $_REQUEST['type']  ?? $_REQUEST['t'] ?? 'regular';
$icon  = $_REQUEST['icon']  ?? $_REQUEST['i'] ?? 'n932f9ibf78fsa';
$color = $_REQUEST['color'] ?? $_REQUEST['c'] ?? false;

if (!file_exists(__DIR__ . "/svgs/$type/")) {
	echo json_encode([
		'type' => $type,
		'error' => "That icon type does not exist. The options are 'brands', 'duotone', 'light', 'regular', 'solid' and 'thin'",
		'success' => false
	]);
	exit;
}

$aliases = json_decode(file_get_contents($file));
if (isset($aliases->$icon)) $icon = $aliases->$icon;
$path = __DIR__ . "/svgs/$type/$icon.svg";

if (!file_exists($path)) {
	echo json_encode([
		'error' => "The icon you requested does not exist!",
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
