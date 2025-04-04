<?php

// The page we wish to display
$file = $_GET[ 'page' ];

// Input validation
$allowed_files = array('file1.php', 'file2.php', 'file3.php', 'file4.php', 'include.php');
if (!in_array($file, $allowed_files)) {
	// This isn't the page we want!
	echo "ERROR: File not found!";
	exit;
}
$file = realpath(dirname(__FILE__) . '/../../' . $file);
if (!$file || strpos($file, realpath(dirname(__FILE__) . '/../../')) !== 0) {
	echo "ERROR: Invalid file path!";
	exit;
}

?>
