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
foreach ($iter as $path => $dir) {$paths[] = $path;}
// remove base
// $paths = array_diff($paths, array($bp));
sort($paths);

# Return
echo implode("\n", $paths);

?>