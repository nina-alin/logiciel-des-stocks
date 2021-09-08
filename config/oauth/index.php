<?php
ini_set('session.save_path', dirname('/var/www/html/session/session'));
ini_set('session.cookie_domain', '.crous-lille.fr');
session_start();

require('oauth.php');
$loggedIn = !is_null($_SESSION['access_token']);
$redirectUri = 'https://' . $_SERVER['SERVER_NAME'] . '/config/oauth/authorize.php';

if (!$loggedIn) {
	header('Location: ' . oAuthService::getLoginUrl($redirectUri));
} else {
	header('Location: https://' . $_SERVER['SERVER_NAME'] . '/pages/dashboard.php');
}
