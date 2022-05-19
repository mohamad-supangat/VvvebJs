<?php
//include 'editor.html';
$html = file_get_contents('editor.html');

$dirs = ['demo', 'my-pages', 'projects', 'undangan'];
//search for html files in demo and my-pages folders
$htmlFiles = [];
foreach ($dirs as $dir) {
	$pattern = '';
	for ($i = 0; $i < 6; $i++) {
		$pattern .= '*/';
		$htmlFiles = array_merge($htmlFiles, glob($dir . '/' . $pattern . '*.html'));
	}
}

foreach ($htmlFiles as $file) {
	if (in_array($file, array('new-page-blank-template.html', 'editor.html'))) continue; //skip template files
	$pathInfo = pathinfo($file);
	$filename = $pathInfo['filename'];
	$folder = preg_replace('@/.+?$@', '', $pathInfo['dirname']);
	$subfolder = preg_replace('@^.+?/@', '', $pathInfo['dirname']);
	if ($filename == 'index' && $subfolder) {
		$filename = $subfolder;
	}
	$url = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
	$name = ucfirst($filename);

	$files .= "{name:'$name', file:'$filename', title:'$name',  url: '$url', folder:'$folder'},";
}


//replace files list from html with the dynamic list from demo folder
$html = str_replace('(pages)', "([$files])", $html);

echo $html;
