<?php
/*
 Plugin Name: Google Analytics
 Plugin URI: http://www.matbra.com/google-analytics-yourls-plugin
 Description: Automaticlly add your Google Analytics code.
 Version: 1.0beta
 Author: Matheus (X-warrior) - matheusbrat@gmail.com
 Author URI: http://matbra.com
 */

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

if(defined('GANALYTICS_ACCOUNT')) { 
	yourls_add_action( 'html_footer', 'showGoogleAnalytics' );
}

function showGoogleAnalytics() { 
	echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '" . GANALYTICS_ACCOUNT . "']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>	";
}
?>
