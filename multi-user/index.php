<?php
session_start();
include("../../../includes/load-yourls.php");
include("muhtmlfunctions.php");

if(YOURLS_PRIVATE === false) {
	die(); // NO DIRECT CALLS IF PUBLIC!
}


/*
 * This is an example file for a public interface and a bookmarklet. It
 * is provided so you can build from it and customize to suit your needs.
 * It's not really part of the project. Don't submit feature requests
 * about this file. It's _your_ job to make it what you need it to be :)
 *
 * Rename to .php
 *
 */


yourls_html_head();


$act = $_GET['act'];
if($act == "logout") {
	$_SESSION['user'] = "";
	unset($_SESSION);
	unset($_SESSION["user"]);
	$error_msg = "Signed off.";
}

if(!isLogged()) {
	//yourls_html_head();
	mu_html_menu();

	// Login form
	//yourls_html_addnew();
	switch($act) {
		case "add_new_url":
		// Part to be executed if FORM has been submitted
		if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

			// Get parameters -- they will all be sanitized in yourls_add_new_link()
			$url     = $_REQUEST['url'];
			$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
			$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
			$text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;

			// Create short URL, receive array $return with various information
			$return  = yourls_add_new_link( $url, $keyword, $title );

			$shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
			$message  = isset( $return['message'] ) ? $return['message'] : '';
			$title    = isset( $return['title'] ) ? $return['title'] : '';
			$status   = isset( $return['status'] ) ? $return['status'] : '';

			// Stop here if bookmarklet with a JSON callback function ("instant" bookmarklets)
			if( isset( $_GET['jsonp'] ) && $_GET['jsonp'] == 'yourls' ) {
				$short = $return['shorturl'] ? $return['shorturl'] : '';
				$message = "Short URL (Ctrl+C to copy)";
				header('Content-type: application/json');
				echo yourls_apply_filter( 'bookmarklet_jsonp', "yourls_callback({'short_url':'$short','message':'$message'});" );

				die();
			}
		}

		// Insert <head> markup and all CSS & JS files
	//	yourls_html_head();

		// Display title
	//	echo "<h1>YOURLS - Your Own URL Shortener</h1>\n";

		// Display left hand menu
	//	yourls_html_menu() ;

		// Part to be executed if FORM has been submitted
		if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

			// Display result message of short link creation
			if( isset( $message ) ) {
				echo "<h2>$message</h2>";
			}

			if( $status == 'success' ) {
				// Include the Copy box and the Quick Share box
				yourls_share_box( $url, $shorturl, $title, $text );

				// Initialize clipboard -- requires js/share.js and js/jquery.zclip.min.js to be properly loaded in the <head>
				echo "<script>init_clipboard();</script>\n";
			}

		// Part to be executed when no form has been submitted
		}





		?>
		<?php







		case "login":

			$username = yourls_escape($_POST['username']);
			$password = $_POST['password'];
			if(!empty($username) && !empty($password)) {
				if(isValidUser($username, $password)) {
					$token = getUserTokenByEmail($username);
					$id = getUserIdByToken($token);
					$_SESSION['user'] = array("id" => $id, "user" => $username, "token" => $token);

					yourls_redirect("index.php");
				} else {
					$error_msg = "Problems to login.";
				require_once 'form.php';
				}
			}
			break;
			case "log_in":
			require_once 'form.php';
			break;
		case "joinform":
			require_once 'formjoin.php';
			break;
		case "join":
			$username = yourls_escape($_POST['username']);
			$password = $_POST['password'];
			if(captchaEnabled()) {
				require_once('recaptchalib.php');
				$privatekey = YOURLS_MULTIUSER_CAPTCHA_PRIVATE_KEY;
				$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
					$error_msg = "Captch is incorrect.";
					require_once 'formjoin.php';
					break;
				}
			}
			if(!empty($username) && !empty($password)) {
				if(validEmail($username) === false) {
					$error_msg = "E-mail not recognized!";
					require_once 'formjoin.php';
				} else {
					$table = YOURLS_DB_TABLE_USERS;
					$results = $ydb->get_results("select user_email from `$table` where `user_email` = '$username'");
					if($results) {
						$error_msg = "Please choose other username.";
						require_once 'formjoin.php';
					} else {
						$token = createRandonToken();
						$password = md5($password);
						$ydb->query("insert into `$table` (user_email, user_password, user_token) values ('$username', '$password', '$token')");
						$results = $ydb->get_results("select user_token from `$table` where `user_email` = '$username'");
						if (!empty($results)) {
							$token = $results[0]->user_token;
							$error_msg = "User $username added with token $token.";
							require_once 'form.php';
						} else {
							require_once 'formjoin.php';
						}
					}
				}
			} else {
				$error_msg = "Please fill all fields.";
				require_once 'formjoin.php';
			}

			break;

		default:
			require_once 'add_new_url.php';

	}

yourls_html_footer();
	die();
} else {
	include("admin.php");

}
