<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ] = 'Help' . $page[ 'title_separator' ].$page[ 'title' ];

if (array_key_exists ("id", $_GET) &&
	array_key_exists ("security", $_GET) &&
	array_key_exists ("locale", $_GET)) {
	$allowed_ids = ['brute', 'csrf', 'exec', 'fi', 'upload', 'sqli', 'sqli_blind', 'xss_r', 'xss_s', 'xss_d', 'weak_id', 'javascript', 'captcha', 'open_redirect', 'authbypass', 'cryptography'];
	$allowed_locales = ['en'];

	$id = in_array($_GET['id'], $allowed_ids) ? $_GET['id'] : '';
	$security = $_GET['security'];
	$locale = in_array($_GET['locale'], $allowed_locales) ? $_GET['locale'] : 'en';

	if (empty($id)) {
		$help = "<p>Invalid vulnerability ID</p>";
		} else {
		$helpFile = realpath(DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/{$id}/help/help" . ($locale != 'en' ? ".{$locale}" : "") . ".php");
		$baseDir = realpath(DVWA_WEB_PAGE_TO_ROOT . 'vulnerabilities');

		if ($helpFile && strpos($helpFile, $baseDir) === 0 && file_exists($helpFile)) {
			ob_start();
			include $helpFile;
			$help = ob_get_contents();
			ob_end_clean();
		}
	}
} else {
	$help = "<p>Not Found</p>";
}

$page[ 'body' ] .= "
<script src='/vulnerabilities/help.js'></script>
<link rel='stylesheet' type='text/css' href='/vulnerabilities/help.css' />

<div class=\"body_padded\">
	{$help}
</div>\n";

dvwaHelpHtmlEcho( $page );

?>
