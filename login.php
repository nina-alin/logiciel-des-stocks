<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nina Alin">

    <title>Logiciel des stocks</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<?php
/*
Script Name: ldapLogin.php
Author: Riontino Raffaele
Author URI: https://www.lelezapp.it/
Description: example script for ldap authentication in PHP
Version: 1.0
*/

$ldapDomain = "@crous-lille.fr";             // set here your ldap domain
$ldapHost = "ldap://10.247.192.202";     // set here your ldap host
$ldapPort = "389";                         // ldap Port (default 389)
$ldapUser  = "";                         // ldap User (rdn or dn)
$ldapPassword = "";                     // ldap associated Password  

$successMessage = "";
$errorMessage = "";

// connect to ldap server
$ldapConnection = ldap_connect($ldapHost, $ldapPort)
    or die("Could not connect to Ldap server.");

if (isset($_POST["ldapLogin"])) {

    if ($ldapConnection) {

        if (isset($_POST["user"]) && $_POST["user"] != "")
            $ldapUser = addslashes(trim($_POST["user"]));
        else
            $errorMessage = "Invalid User value!!";

        if (isset($_POST["password"]) && $_POST["password"] != "")
            $ldapPassword = addslashes(trim($_POST["password"]));
        else
            $errorMessage = "Invalid Password value!!";

        if ($errorMessage == "") {
            // binding to ldap server
            ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
            $ldapbind = @ldap_bind($ldapConnection, $ldapUser . $ldapDomain, $ldapPassword);

            // verify binding
            if ($ldapbind) {
                /* ldap_close($ldapConnection);    // close ldap connection
                $successMessage = "Login done correctly!!";*/
                session_start();
                $_SESSION['username'] = $ldapUser;
                echo 'Vous êtes connecté !';
                header("Location: dashboard.php");
            } else
                $errorMessage = "Invalid credentials!";
        }
    }
}
?>
<html>

<body data-rsssl=1 data-rsssl=1>
    <?php
    if ($errorMessage != "") echo "<h3 style='color:blue;'>$errorMessage</h3>";
    if ($successMessage != "") echo "<h3 style='color:blue;'>$successMessage</h3>";
    ?>
    <h3 style="color:orange">Ldap Login</h3>

    <form action="" method="post" style="display:inline-block;">
        <table style="display:inline-block;">
            <tr>
                <td>User</td>
                <td><input type="text" name="user" value="" maxlength="50"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="" maxlength="50"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="ldapLogin" value="Ldap Login"></td>
            </tr>
        </table>
    </form>
</body>

</html>