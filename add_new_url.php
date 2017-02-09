<?php
if(strpos($_SERVER["REQUEST_URI"],"add_new_url.php") === false) {

	if(YOURLS_PRIVATE === false || !defined( 'YOURLS_ABSPATH' )) {
		die(); // NO DIRECT CALLS IF PUBLIC OR if YOURLS_ABSPATH NOT DEFINED!
	}

 echo yourls_notice_box("<center><b>Enter a new URL to shorten</b></center>");
	mu_html_add_new_url($error_msg);

} else {

}
?>
