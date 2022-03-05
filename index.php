<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
include_once("../db.php");

if( $_REQUEST['username'] AND $_REQUEST['password'] ) 
{
	$sql = "SELECT * FROM cs_users WHERE username = '".$_REQUEST['username']."' AND password = '".$_REQUEST['password']."' ";
	$result = mysql_query($sql) or die("Error quick_answer_menu.phpname".mysql_error());
	if(mysql_num_rows($result))
	{
		$row = mysql_fetch_array($result);
		extract($row);

		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['user_id'] =  $user_id;

		if($twitter_oauth_token_secret != "" AND $twitter_oauth_token != "")
		{
			$_SESSION['twitter_oauth_token_secret'] = $twitter_oauth_token_secret;
			$_SESSION['twitter_oauth_token'] = $twitter_oauth_token;
			$_SESSION['twitter_oauth_verifier'] = $twitter_oauth_verifier;
			$_SESSION['twitter_user_id'] =  $twitter_user_id;
			$_SESSION['twitter_screen_name'] = $twitter_screen_name;

			header('Location: ./admin.php');
		}
		else
		{
//			die(print_r($_SESSION).print_r($_REQUEST));

			require_once('twitteroauth/twitteroauth.php');
			require_once('config.php');

			/* Build TwitterOAuth object with client credentials. */
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
			 
			/* Get temporary credentials. */
			$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

			/* Save temporary credentials to session. */
			$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			 
			/* If last connection failed don't display authorization link. */
			switch ($connection->http_code) {
			  case 200:
			    /* Build authorize URL and redirect user to Twitter. */
			    $url = $connection->getAuthorizeURL($token);
			    header('Location: ' . $url); 
			    break;
			  default:
			    /* Show notification if something went wrong. */
			    echo 'Could not connect to Twitter. Refresh the page or try again later.';
			}
		}

	}
	else
		echo "kullanıcı adı şifre yanlış";
}
elseif (empty($_SESSION['username']))
{?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>TweetDuvar.im - Boğaziçi Üniversitesi İşletme ve Ekonomi Kulübü</title>
        <link rel="apple-touch-icon" href="images/Apple-Touch-Icon.png"/>
  <link href="css/style.css" rel="stylesheet" type="text/css" />

	<script src="../buik/jquery.min.js" type="text/javascript" ></script>

<script type="text/javascript">
	$(function() {   			
	
	
		var theWindow        = $(window),
		    $bg              = $("#bg"),
		    aspectRatio      = $bg.width() / $bg.height();
		    			    		
		function resizeBg() {
			
			if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
			    $bg
			    	.removeClass()
			    	.addClass('bgheight');

			} else {
			    $bg
			    	.removeClass()
			    	.addClass('bgwidth');

			}
						
		}
		                   			
		theWindow.resize(function() {
			resizeBg();
		}).trigger("resize");
	
	});
</script>




<body>

<img src="images/bg.png" id="bg" alt="">
<?php
	echo "<form action=\"index.php\" method=\"post\">
	<input type=\"text\" name=\"username\">
	<input type=\"password\" name=\"password\">
	<input type=\"submit\">
	</form>";
}
else
	header('Location: ./admin.php');

?>