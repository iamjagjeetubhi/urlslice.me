<html>
<body>
  <?php
include("includes/load-yourls.php");

include("muhtmlfunctions.php");
include("mufunctions.php");


//echo $_SERVER["QUERY_STRING"];
//htmlspecialchars($_GET["user_email"]);
//htmlspecialchars($_GET["verification_code"]);

// check first if record exists
/*$query = "SELECT id FROM users WHERE verification_code = ? and verified = '0'";
$stmt = $con->prepare( $query );
$stmt->bindParam(1, $_GET['code']);
$stmt->execute();
$num = $stmt->rowCount();

if($num>0){

    // update the 'verified' field, from 0 to 1 (unverified to verified)
    $query = "UPDATE users
                set verified = '1'
                where verification_code = :verification_code";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':verification_code', $_GET['code']);

    if($stmt->execute()){
        // tell the user
        echo "<div>Your email is valid, thanks!. You may now login.</div>";
    }else{
        echo "<div>Unable to update verification code.</div>";
        //print_r($stmt->errorInfo());
    }

}else{
    // tell the user he should not be in this page
    echo "<div>We can't find your verification code.</div>";
}*/



if(isset($_GET['verification_code']) && isset($_GET['user_email']))
{


$username=htmlspecialchars($_GET["user_email"]);
$password=htmlspecialchars($_GET["verification_code"]);
/*$table = YOURLS_DB_TABLE_USERS;
$results = $ydb->get_results("select verified from `$table` where `verification_code` = '$verificationCode' AND `user_email` = '$username'");
if($results) {


  	$ydb->query("UPDATE yourls_users SET verified = '1' WHERE user_email = 'iamjagjeetubhi@gmail.com' AND  `verification_code` = '$verificationCode'");
      $results = $ydb->get_results("SELECT verified from `$table` where `user_email` = '$username' and `verification_code` = '$verificationCode'");

        if($results){
          echo "You have verified your mail ID";
      }
      else{
        echo "Sorry Email address in not verified";
      }
          }
          else{
            echo "Sorry Email address in not verified";
          }
        }*/
        echo $username;
        echo $password;
    if(isVerifiedUser($username, $password)) {

            echo "activated";
          }

          else{

            echo "activate your account";
          }

}



?>
</body>
</html>
