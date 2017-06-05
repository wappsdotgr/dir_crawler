<?php

# Check Path 'isset'
$bp = (isset($_POST['bp']) && $_POST['bp'] != '') ? $_POST['bp'] : die('Path not specified.');

# Declare Iterator
$iter = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($bp, RecursiveDirectoryIterator::SKIP_DOTS),
	RecursiveIteratorIterator::SELF_FIRST,
	RecursiveIteratorIterator::CATCH_GET_CHILD
);

# Scan + Prepare
$paths = array($bp);
foreach ($iter as $path => $dir) {
	$paths[] = str_replace($bp."\\", "", $path);
}

// Remove Base + Sort
$paths = array_diff($paths, array($bp));
sort($paths);

# Return

$output = str_replace($bp."\\", "", implode("\n", $paths));

// echo implode("\n", $paths);


# Create Zip + Add Files
// $zipname = date('Ymd').' - Movies.zip';
$zipname = 'kati.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($paths as $zpath) {
	if (is_dir($bp."\\".$zpath)) {
		$zip->addEmptyDir($zpath);
	}
	else {	
		$zip->addFile($bp."\\".$zpath, $zpath);
	}
}
$zip->close();


echo $zipname;

/*
# Return Header
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
// header('Content-Length: '.filesize($zipname));
readfile($zipname);

# Delete Zip From Server
// unlink($zipname);
*/

?>