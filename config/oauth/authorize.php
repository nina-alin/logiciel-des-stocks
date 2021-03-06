<?php
ini_set('session.save_path', dirname('/var/www/html/session/session'));
ini_set('session.cookie_domain', '.crous-lille.fr');
session_start();

require_once('oauth.php');
require_once('outlook.php');

$auth_code = $_GET['code'];
$redirectUri = 'https://' . $_SERVER['SERVER_NAME'] . '/config/oauth/authorize.php';


$tokens = oAuthService::getTokenFromAuthCode($auth_code, $redirectUri);

if ($tokens['access_token']) {

  $_SESSION['access_token'] = $tokens['access_token'];

  $_SESSION['refresh_token'] = $tokens['refresh_token'];
  //var_dump($_SESSION);
  // expires_in is in seconds
  // Get current timestamp (seconds since Unix Epoch) and
  // add expires_in to get expiration time
  // Subtract 5 minutes to allow for clock differences
  $expiration = time() + $tokens['expires_in'] + 3600;
  $_SESSION['token_expires'] = $expiration;

  // Get the user's email
  $user = OutlookService::getUser($tokens['access_token']);
  $_SESSION['user_email'] = $user['EmailAddress'];

  // Redirect back to home page
  header("Location: https://" . $_SERVER['SERVER_NAME'] . "/identification.php");
} else {
  echo "<p>ERROR: " . $tokens['error'] . "</p>";
}
