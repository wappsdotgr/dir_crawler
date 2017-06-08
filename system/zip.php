<?php

# Check Path 'isset'
$bp = (isset($_POST['bp']) && $_POST['bp'] != '') ? $_POST['bp'] : die('Path not specified.');
$exts = (isset($_POST['exts']) && $_POST['exts'] != '') ? explode(',', $_POST['exts']) : null;

# Declare Iterator
$iter = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($bp, RecursiveDirectoryIterator::SKIP_DOTS),
	RecursiveIteratorIterator::SELF_FIRST,
	RecursiveIteratorIterator::CATCH_GET_CHILD
);

# Scan + Prepare
$paths = array($bp);
foreach ($iter as $path => $dir) {
	if ($exts !== null && !in_array(pathinfo($path, PATHINFO_EXTENSION), $exts) && is_file($path)) {
		unset($paths[$path]);
	} else {
		$paths[] = str_replace($bp."\\", "", $path);
	}
}

# Remove Base + Sort
$paths = array_diff($paths, array($bp));
sort($paths);

# Create Zip + Add Files
$zipname = 'backup.zip';
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

# Return
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